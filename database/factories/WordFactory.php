<?php

namespace Database\Factories;

use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordFactory extends Factory
{
    protected $model = Word::class;

    final public function definition(): array
    {
        $this->faker->locale = 'is_IS'; // Set the locale to Icelandic

        return [
            'name' => $this->faker->word,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
