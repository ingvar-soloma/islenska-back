<?php

namespace App\Console\Commands;

use App\Models\Language;
use App\Models\Word;
use App\Services\TranslationApiService;
use Illuminate\Console\Command;

class TranslateWordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translate:words
                            {count=10 : Number of words to translate}
                            {--language= : Target language code (e.g., en, uk, is)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate a specified number of words to a selected language';

    /**
     * Execute the console command.
     */
    public function handle(TranslationApiService $translationService)
    {
        $count = (int) $this->argument('count');
        $languageCode = $this->option('language');

        // Validate language code
        if (!$languageCode) {
            $languages = Language::all();
            $languageCode = $this->choice(
                'Select target language:',
                $languages->pluck('symbol')->toArray(),
                0
            );
        }

        $targetLanguage = Language::where('symbol', $languageCode)->first();
        if (!$targetLanguage) {
            $this->error("Language with code '{$languageCode}' not found.");
            return 1;
        }

        // Get words that need translation
        $words = $this->getWordsNeedingTranslation($targetLanguage->id, $count);

        if ($words->isEmpty()) {
            $this->info("No words found that need translation to {$targetLanguage->name}.");
            return 0;
        }

        $this->info("Translating {$words->count()} words to {$targetLanguage->name}...");

        $progressBar = $this->output->createProgressBar($words->count());
        $progressBar->start();

        $translatedCount = 0;

        foreach ($words as $word) {
            $sourceLanguage = Language::find($word->language_id);

            if (!$sourceLanguage) {
                $progressBar->advance();
                continue;
            }

            // Get translation variants
            $translationVariants = $translationService->translateWithVariants(
                $word->name,
                $sourceLanguage->symbol,
                $targetLanguage->symbol
            );

            if (!$translationVariants || empty($translationVariants)) {
                $progressBar->advance();
                continue;
            }

            // Process each translation variant
            $variantsAdded = 0;
            foreach ($translationVariants as $variant) {
                $translatedText = $variant['translation'];
                $quality = $variant['quality'];

                // Skip low quality translations
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
                $translation = \App\Models\Relations\Translation::firstOrCreate(
                    [
                        'word_from_id' => $word->id,
                        'word_to_id' => $translatedWord->id
                    ],
                    [
                        'quality' => $quality
                    ]
                );

                // Create reverse translation relationship with same quality
                $reverseTranslation = \App\Models\Relations\Translation::firstOrCreate(
                    [
                        'word_from_id' => $translatedWord->id,
                        'word_to_id' => $word->id
                    ],
                    [
                        'quality' => $quality
                    ]
                );

                $variantsAdded++;
            }

            if ($variantsAdded > 0) {
                $translatedCount++;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();

        $this->info("Successfully translated {$translatedCount} words to {$targetLanguage->name}.");

        return 0;
    }

    /**
     * Get words that need translation to the target language
     *
     * @param int $targetLanguageId
     * @param int $count
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getWordsNeedingTranslation(int $targetLanguageId, int $count)
    {
        // Get words that don't have translations to the target language
        return Word::whereNotIn('id', function ($query) use ($targetLanguageId) {
            $query->select('word_from_id')
                ->from('translations')
                ->join('words', 'translations.word_to_id', '=', 'words.id')
                ->where('words.language_id', $targetLanguageId);
        })
        ->where('language_id', '!=', $targetLanguageId)
        ->inRandomOrder()
        ->limit($count)
        ->get();
    }
}
