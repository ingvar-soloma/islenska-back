<?php

namespace Database\Factories;

use App\Models\AudioFile;
use App\Models\Level;
use App\Models\TextEntity;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class TextEntityFactory extends Factory
{

    private static ?array $topicIds = null;
    private static ?array $audioFileIds = null;
    protected $model = TextEntity::class;

    final public function definition(): array
    {
        if (self::$topicIds === null) {
            self::$topicIds = Topic::all('id')->pluck('id')->toArray();
        }

        if (self::$audioFileIds === null) {
            self::$audioFileIds = AudioFile::all('id')->pluck('id')->toArray();
        }

        return [
            'text' => $this->faker->text,
            'topic_id' => $this->faker->randomElement(self::$topicIds),
            'audio_file_id' => $this->faker->randomElement(self::$audioFileIds),
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
