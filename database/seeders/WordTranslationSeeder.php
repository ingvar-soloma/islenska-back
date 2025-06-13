<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Relations\Translation;
use App\Models\Word;
use App\Services\TranslationApiService;
use Illuminate\Database\Seeder;

class WordTranslationSeeder extends Seeder
{
    protected TranslationApiService $translationService;

    public function __construct(TranslationApiService $translationService)
    {
        $this->translationService = $translationService;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    final public function run(): void
    {
        // Get all words that don't have any translations
        $wordsWithoutTranslations = $this->getWordsWithoutTranslations();

        if ($wordsWithoutTranslations->isEmpty()) {
            $this->command->info('No words without translations found.');
            return;
        }

        $this->command->info('Found ' . $wordsWithoutTranslations->count() . ' words without translations.');

        // Create translations for these words
        $this->createTranslations($wordsWithoutTranslations->all());

        $this->command->info('Translations created successfully.');
    }

    /**
     * Get all words that don't have any translations
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getWordsWithoutTranslations()
    {
        // Get all words that don't have any outgoing translations
        $wordsWithoutOutgoingTranslations = Word::whereNotIn('id', function ($query) {
            $query->select('word_from_id')
                ->from('translations')
                ->distinct();
        })->get();

        // Get all words that have some outgoing translations but might be missing translations to some languages
        $wordsWithIncompleteTranslations = Word::whereIn('id', function ($query) {
            $query->select('word_from_id')
                ->from('translations')
                ->distinct();
        })->get();

        // For words with some translations, check if they have translations to all languages
        $languageCount = Language::count();
        $wordsNeedingMoreTranslations = $wordsWithIncompleteTranslations->filter(function ($word) use ($languageCount) {
            // Count how many languages this word is translated to
            $translationCount = Translation::where('word_from_id', $word->id)
                ->distinct('word_to_id')
                ->count();

            // If the word is translated to fewer languages than exist, it needs more translations
            // Subtract 1 because we don't translate to the same language
            return $translationCount < ($languageCount - 1);
        });

        // Combine both collections
        return $wordsWithoutOutgoingTranslations->merge($wordsNeedingMoreTranslations);
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

            // Get languages that this word is already translated to
            $existingTargetLanguageIds = Translation::where('word_from_id', $word->id)
                ->join('words', 'translations.word_to_id', '=', 'words.id')
                ->pluck('words.language_id')
                ->toArray();

            // Translate to each other language
            foreach ($languages as $targetLanguage) {
                // Skip if source and target languages are the same
                if ($sourceLanguage->id === $targetLanguage->id) {
                    continue;
                }

                // Skip if word is already translated to this language
                if (in_array($targetLanguage->id, $existingTargetLanguageIds)) {
                    continue;
                }

                // Get translation variants from API
                $translationVariants = $this->translationService->translateWithVariants(
                    $word->name,
                    $sourceLanguage->symbol,
                    $targetLanguage->symbol
                );

                if (!$translationVariants || empty($translationVariants)) {
                    continue;
                }

                // Process each translation variant
                foreach ($translationVariants as $variant) {
                    $translatedText = $variant['translation'];
                    $quality = $variant['quality'];

                    // Skip low quality translations (optional, adjust threshold as needed)
                    if ($quality < 0.5) {
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

                    // Create translation relationship with quality
                    Translation::firstOrCreate(
                        [
                            'word_from_id' => $word->id,
                            'word_to_id' => $translatedWord->id
                        ],
                        [
                            'quality' => $quality
                        ]
                    );

                    // Create reverse translation relationship with same quality
                    Translation::firstOrCreate(
                        [
                            'word_from_id' => $translatedWord->id,
                            'word_to_id' => $word->id
                        ],
                        [
                            'quality' => $quality
                        ]
                    );
                }
            }
        }
    }
}
