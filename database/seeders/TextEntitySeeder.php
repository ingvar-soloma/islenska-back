<?php

namespace Database\Seeders;

use App\Models\TextEntity;
use Illuminate\Database\Seeder;

class TextEntitySeeder extends Seeder
{
    final public function run(): void
    {
        TextEntity::factory()->count(10)->create();
    }
}
