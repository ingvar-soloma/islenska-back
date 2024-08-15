<?php

namespace App\Http\Services;

use App\Http\Repositories\LanguageRepository;
use App\Http\Repositories\TopicRepository;
use App\Http\Repositories\WordRepository;
use App\Http\Repositories\WordTextEntityRepository;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
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
        return parent::getAllData($validated, $with);
    }

    final public function store(array $validated): ?Model
    {
        if (isset($validated['translation_id'])) {
            $translationId = $validated['translation_id'];
            unset($validated['translation_id']);
        }

        $word = parent::store($validated);
        $this->attachTranslation($word, $translationId);

        return $word;
    }

    final public function update(array $validated, Model|int $id): Model
    {
        $word = $this->show($id);
        $this->createIfNeededAndAttachLastTranslation($word, $validated);

        return parent::update($validated, $id);
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

    private function attachTranslation(Word $word, mixed $translationId): void
    {
        $word->translationsFrom()->attach($translationId);
    }

    private function createIfNeededAndAttachLastTranslation(Word $word, array &$validated): void
    {
        if (!isset($validated['translations'])) {
            return;
        }
        $validated['translation'] = $validated['translations'][count($validated['translations']) - 1];

        if (isset($validated['translation']['language'])) {
            $languageRepository = app(LanguageRepository::class);
            $languageId = $languageRepository->getAll(['symbol' => $validated['language_to']])->first()->id;
            $validated['translation']['language_id'] = $languageId;
        }

        if (isset($validated['translation']['word_id'])) {
            $translationId = $validated['translation']['word_id'];
        } else {
            $translationId = app(WordRepository::class)->create($validated['translation'])->id;
        }

        $word->translationsFrom()->attach($translationId);

        unset($validated['translation']);

    }
}
