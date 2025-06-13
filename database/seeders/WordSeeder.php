<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Relations\Translation;
use App\Models\Relations\WordTextEntity;
use App\Models\TextEntity;
use App\Models\Word;
use App\Services\TranslationApiService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WordSeeder extends Seeder
{
    protected TranslationApiService $translationService;

    public function __construct(TranslationApiService $translationService)
    {
        $this->translationService = $translationService;
    }

    final public function run(): void
    {
        if (Word::count() === 0) {
//            $languageId = Language::where('symbol', '!=', 'is')->first()->id;
//            Word::factory()->count(50)->create(['language_id' => $languageId]);
        }

        $textEntities = TextEntity::all();

        $wordsData = [];

        foreach ($textEntities as $textEntity) {
            $textWords = preg_split('/([^a-zA-ZáðéíóúýþæöÁÐÉÍÓÚÝÞÆÖ]+)/u', $textEntity->text, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($textWords as $word) {
                if (preg_match('/^[\wáðéíóúýþæöÁÐÉÍÓÚÝÞÆÖ]+$/iu', $word)) {
                    $wordsData[] = ["name" => Str::lower($word), "language_id" => $textEntity['language_id']];
                }
            }
        }

        $wordsData = array_map("unserialize", array_unique(array_map("serialize", $wordsData)));
        $existingWords = Word::whereIn('name', array_column($wordsData, 'name'))
            ->whereIn('language_id', array_column($wordsData, 'language_id'))
            ->select('name', 'language_id')
            ->get()
            ->toArray();

        $newWordsData = array_filter($wordsData, function ($wordData) use ($existingWords) {
            foreach ($existingWords as $existingWord) {
                if ($existingWord['name'] === $wordData['name'] && $existingWord['language_id'] === $wordData['language_id']) {
                    return false;
                }
            }
            return true;
        });

        $words = [];
        foreach ($newWordsData as $wordData) {
            $words[] = Word::firstOrCreate(
                [
                    'name' => $wordData['name'],
                    'language_id' => $wordData['language_id']
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }

        // Create translations for each word
        $this->createTranslations($words);

        $wordTextEntityData = [];
        foreach ($words as $word) {
            foreach ($textEntities as $textEntity) {
                if (str_contains(Str::lower($textEntity['text']), $word['name'])) {
                    $wordTextEntityData[] = [
                        'word_id' => $word['id'],
                        'text_entity_id' => $textEntity['id'],
                    ];
                }
            }
        }

        WordTextEntity::insert($wordTextEntityData);
    }

    /**
     * Create translations for each word
     *
     * @param array $words Array of Word models
     * @return void
     */
    private function createTranslations(array $words): void
    {
        // Get all languages
        $languages = Language::all();

        foreach ($words as $word) {
            $sourceLanguage = $languages->firstWhere('id', $word->language_id);

            if (!$sourceLanguage) {
                continue;
            }

            // Translate to each other language
            foreach ($languages as $targetLanguage) {
                // Skip if source and target languages are the same
                if ($sourceLanguage->id === $targetLanguage->id) {
                    continue;
                }

                // Check if translation already exists
                $existingTranslation = Translation::where('word_from_id', $word->id)
                    ->where('word_to_id', function ($query) use ($targetLanguage, $word) {
                        $query->select('id')
                            ->from('words')
                            ->where('language_id', $targetLanguage->id)
                            ->whereRaw('LOWER(name) = ?', [strtolower($word->name)]);
                    })
                    ->exists();

                if ($existingTranslation) {
                    continue;
                }

                // Get translation from API
                $translatedText = $this->translationService->translate(
                    $word->name,
                    $sourceLanguage->symbol,
                    $targetLanguage->symbol
                );

                if (!$translatedText) {
                    continue;
                }

                // Create or find the translated word
                $translatedWord = Word::firstOrCreate(
                    [
                        'name' => strtolower($translatedText),
                        'language_id' => $targetLanguage->id
                    ],
                    [
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );

                // Create translation relationship
                Translation::firstOrCreate([
                    'word_from_id' => $word->id,
                    'word_to_id' => $translatedWord->id
                ]);

                // Create reverse translation relationship
                Translation::firstOrCreate([
                    'word_from_id' => $translatedWord->id,
                    'word_to_id' => $word->id
                ]);
            }
        }
    }
}
