<?php

namespace Database\Seeders;

use App\Models\Relations\Translation;
use Illuminate\Database\Seeder;

class TranslationSeeder extends Seeder
{
    final public function run(): void
    {
        // Translations are now handled in WordSeeder using the MyMemory API
        // This seeder is kept for backward compatibility
    }
}
