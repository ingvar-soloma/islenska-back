<?php

namespace Database\Factories;

use App\Models\Translation;
use App\Models\Word;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslationFactory extends Factory
{
    private static ?Collection $words = null;
    protected $model = Translation::class;

    /**
     * @throws \Exception
     */
    final public function definition(): array
    {
        if (static::$words === null) {
            static::$words = Word::all(['id', 'language_id']);
        }
        do {
            $wordFrom = static::$words->random();
            $wordTo = static::$words->random();
        } while ($wordFrom->language_id === $wordTo->language_id);

        return [
            'word_from_id' => $wordFrom,
            'word_to_id' => $wordTo,
        ];
    }
}
