<?php

namespace Database\Factories;

use App\Models\Language;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory
{
    private static ?array $languageIds = null;
    protected $model = Word::class;

    final public function definition(): array
    {
        if (self::$languageIds === null) {
            self::$languageIds = Language::all('id')->pluck('id')->toArray();
        }


        return [
            'name' => $this->faker->word,
            'language_id' => $this->faker->randomElement(self::$languageIds),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
