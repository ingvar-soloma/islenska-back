<?php

namespace Database\Factories;

use App\Models\TextEntity;
use App\Models\TextEntityGuesting;
use Illuminate\Database\Eloquent\Factories\Factory;

class TextEntityGuestingFactory extends Factory
{
    private static ?array $textEntityIds = null;
    protected $model = TextEntityGuesting::class;

    final public function definition(): array
    {
        if (self::$textEntityIds === null) {
            self::$textEntityIds = TextEntity::all('id')->pluck('id')->toArray();
        }

        return [
            'text_entity_id' => $this->faker->randomElement(self::$textEntityIds),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear()
        ];
    }
}
