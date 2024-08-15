<?php

namespace Database\Factories;

use App\Models\AudioFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AudioFileFactory extends Factory
{
    protected $model = AudioFile::class;

    public function definition()
    {
        return [
            'file_name' => $this->faker->name,
            'created_at' => $this->faker->dateTime,
            'updated_at' => $this->faker->dateTime,
        ];
    }
}
