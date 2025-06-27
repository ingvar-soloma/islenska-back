<?php

namespace Database\Factories;

use App\Models\Relations\UserTranslation;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserTranslationFactory extends Factory
{
    protected $model = UserTranslation::class;

    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'translation_id' => \App\Models\Translation::factory(),
        ];
    }
}
