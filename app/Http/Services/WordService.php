<?php

namespace App\Http\Services;

use App\Http\Repositories\LanguageRepository;
use App\Http\Repositories\TopicRepository;
use App\Http\Repositories\WordRepository;
use App\Http\Repositories\WordTextEntityRepository;
use Illuminate\Support\Collection;

class WordService extends BaseService
{
    public function __construct(readonly protected WordRepository $repository)
    {
    }

    final public function getAllData(array $validated, array $with): Collection
    {
        $this->applyLanguageFromToFilter($validated, $with);
        $this->applyTopicIdFilter($validated, $with);
        $this->applyTextEntityIdFilter($validated, $with);

        app(WordRepository::class); //  laravel bug fix
        return $this->repository->getAll($validated, $with);
    }

    private function applyTopicIdFilter(array &$validated, array &$with): void
    {
        if (isset($validated['topic_id'])) {
            $topicRepository = app(TopicRepository::class);
            // may be union with parameter text_entity_id
            $validated['text_entity_id'] = $topicRepository->getAll(['id' => $validated['topic_id']], ['textEntities'])
                ->flatMap(fn($topic) => $topic->textEntities->pluck('id'))
                ->toArray();
            unset($validated['topic_id']);
        }
    }

    private function applyTextEntityIdFilter(array &$validated, array &$with): void
    {
        if (isset($validated['text_entity_id'])) {
            $wordTextEntityRepository = app(WordTextEntityRepository::class);
            $validated['id'] = $wordTextEntityRepository->getAll(['text_entity_id' => $validated['text_entity_id']])
                ->pluck('word_id')
                ->toArray();
            unset($validated['text_entity_id']);
        }
    }

    private function applyLanguageFromToFilter(array &$validated, array &$with): void
    {
        [$languageFromId, $languageToId] = $this->getLanguageIds($validated);
        $validated['language_id'] = $languageFromId;
        $this->applyLanguageToFilterForTranslations($with, $languageToId);
    }

    private function applyLanguageToFilterForTranslations(array &$with, int $languageToId): void
    {
        foreach (['translationsFrom', 'translationsTo'] as $relation) {
            if (isset($with[$relation])) {
                $with[$relation] = fn($query) => $query->where('language_id', $languageToId);
            }
        }
    }

    private function getLanguageIds(array &$validated): array
    {
        $languageRepository = app(LanguageRepository::class);
        $languageIds = $languageRepository->getAll([
            'symbol' => [$validated['language_from'], $validated['language_to']]
        ]);

        $languageFromId = $languageIds->firstWhere('symbol', $validated['language_from'])->id;
        $languageToId = $languageIds->firstWhere('symbol', $validated['language_to'])->id;

        unset($validated['language_from'], $validated['language_to']);
        return [$languageFromId, $languageToId];
    }
}
