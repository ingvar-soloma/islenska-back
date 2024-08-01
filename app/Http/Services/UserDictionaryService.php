<?php

namespace App\Http\Services;

use App\Http\Repositories\LanguageRepository;
use App\Http\Repositories\UserDictionaryRepository;
use App\Http\Repositories\WordRepository;
use Illuminate\Support\Collection;

class UserDictionaryService extends BaseService
{

    public function __construct(readonly protected UserDictionaryRepository $repository)
    {
    }

    final public function getAllData(array $validated, array $with): Collection
    {
        $this->applyLanguageFilter($validated, $with);

        app(UserDictionaryRepository::class); //  laravel bug fix
        return $this->repository->getAll($validated, $with);
    }

    private function applyLanguageFilter(array &$validated, array &$with): void
    {
        $languageRepository = app(LanguageRepository::class);
        $languageId = $languageRepository->getAll(['symbol' => $validated['language_from']])->first()->id;
        unset($validated['language_from']);


        $wordRepository = app(WordRepository::class);
        $validated['word_id'] = $wordRepository->getAll(['language_id' => $languageId])
            ->pluck('id')
            ->toArray();
    }
}
