<?php

namespace Database\Factories;

use App\Models\Level;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopicFactory extends Factory
{
    private static ?array $levelIds = null;
    protected $model = Topic::class;

    final public function definition(): array
    {
        if (self::$levelIds === null) {
            self::$levelIds = Level::all('id')->pluck('id')->toArray();
        }

        return [
            'name' => $this->faker->name,
            'level_id' => $this->faker->randomElement(self::$levelIds),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime
        ];
    }
}
