<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    final public function run(): void
    {
        if (Translation::count() === 0) {
            Translation::factory()->count(100)->create();
        }
    }
}
