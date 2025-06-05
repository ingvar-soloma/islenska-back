<?php

namespace Database\Factories;

use App\Models\Relations\WordImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class WordImageFactory extends Factory
{
    protected $model = WordImage::class;

    final public function definition(): array
    {
        return [
            'word_id' => $this->faker->numberBetween(1, 10),
            'image_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
