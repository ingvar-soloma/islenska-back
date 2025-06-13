<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationApiService
{
    private string $apiUrl = 'https://api.mymemory.translated.net/get';
    private array $localeCorrections = [
        'ua' => 'uk', // Ukrainian
    ];

    /**
     * Translate text using MyMemory API and return all translation variants sorted by quality
     *
     * @param string $text Text to translate
     * @param string $fromLang Source language code
     * @param string $toLang Target language code
     * @return array|null Array of translation matches or null if translation failed
     */
    final public function translateWithVariants(string $text, string $fromLang, string $toLang): ?array
    {
        // Apply locale corrections if needed
        $fromLang = $this->correctLocale($fromLang);
        $toLang = $this->correctLocale($toLang);

        try {
            $response = Http::get($this->apiUrl, [
                'q' => $text,
                'langpair' => "{$fromLang}|{$toLang}"
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['matches']) && is_array($data['matches'])) {
                    $matches = [];

                    foreach ($data['matches'] as $match) {
                        $matches[] = [
                            'translation' => $match['translation'],
                            'quality' => (float) $match['quality'],
                            'match' => $match['match']
                        ];
                    }

                    // Sort matches by quality in descending order
                    usort($matches, function ($a, $b) {
                        return $b['quality'] <=> $a['quality'];
                    });

                    return $matches;
                }
            }

            Log::warning('Translation API failed to get variants', [
                'text' => $text,
                'from' => $fromLang,
                'to' => $toLang,
                'response' => $response->json()
            ]);

            return null;
        } catch (\Exception $e) {
            Log::error('Translation API exception when getting variants', [
                'text' => $text,
                'from' => $fromLang,
                'to' => $toLang,
                'error' => $e->getMessage()
            ]);

            return null;
        }
    }

    /**
     * Translate text using MyMemory API
     *
     * @param string $text Text to translate
     * @param string $fromLang Source language code
     * @param string $toLang Target language code
     * @return string|null Translated text or null if translation failed
     */
    final public function translate(string $text, string $fromLang, string $toLang): ?string
    {
        $variants = $this->translateWithVariants($text, $fromLang, $toLang);

        if ($variants && count($variants) > 0) {
            // Return the highest quality translation
            return $variants[0]['translation'];
        }

        return null;
    }

    /**
     * Correct locale code if needed
     *
     * @param string $locale The locale code to check
     * @return string The corrected locale code
     */
    private function correctLocale(string $locale): string
    {
        return $this->localeCorrections[$locale] ?? $locale;
    }
}
