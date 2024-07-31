<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDictionaryFactory extends Factory
{
    private static ?array $userIds = null;
    private static ?array $wordIds = null;

    final public function definition(): array
    {
        if (self::$userIds === null) {
            self::$userIds = User::all('id')->pluck('id')->toArray();
        }

        if (self::$wordIds === null) {
            self::$wordIds = Word::all('id')->pluck('id')->toArray();
        }

        return [
            'user_id' => $this->faker->randomElement(self::$userIds),
            'word_id' => $this->faker->randomElement(self::$wordIds),
            'level_of_knowing' => $this->faker->numberBetween(1, 5),
            'stability' => $this->faker->numberBetween(1, 5),
            'created_at' => $this->faker->dateTimeThisYear(),
            'updated_at' => $this->faker->dateTimeThisYear(),
        ];
    }
}
