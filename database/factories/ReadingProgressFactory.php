<?php

namespace Database\Factories;

use App\Models\ReadingProgress;
use App\Models\TextEntity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReadingProgressFactory extends Factory
{
    private static $textEntityIds;
    private static $userIds;
    protected $model = ReadingProgress::class;

    final public function definition(): array
    {
        if (self::$textEntityIds === null) {
            self::$textEntityIds = TextEntity::all('id')->pluck('id')->toArray();
        }

        if (self::$userIds === null) {
            self::$userIds = User::all('id')->pluck('id')->toArray();
        }

        return [
            'text_entity_id' => $this->faker->randomElement(self::$textEntityIds),
            'user_id' => $this->faker->randomElement(self::$userIds),
            'read' => $this->faker->boolean,
            'created_at' => $this->faker->dateTimeThisYear,
            'updated_at' => $this->faker->dateTimeThisYear
        ];
    }
}
