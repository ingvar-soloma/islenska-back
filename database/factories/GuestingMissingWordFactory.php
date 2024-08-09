<?php

namespace Database\Factories;

use App\Models\GuestingMissingWord;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuestingMissingWordFactory extends Factory
{
    private static ?array $textEntitiesGuestingIds = null;
    protected $model = GuestingMissingWord::class;

    final public function definition(): array
    {
        if (self::$textEntitiesGuestingIds === null) {
            self::$textEntitiesGuestingIds = GuestingMissingWord::all('text_entities_guesting_id')->pluck('text_entities_guesting_id')->toArray();
        }

        return [
            'text_entities_guesting_id' => $this->faker->randomElement(self::$textEntitiesGuestingIds),
            'word_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
