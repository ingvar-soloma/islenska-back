<?php

namespace Database\Seeders;

use App\Models\Relations\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    final public function run(): void
    {
        if (Translation::count() === 0) {
//            Translation::factory()->count(40)->create();

        }
    }
}
