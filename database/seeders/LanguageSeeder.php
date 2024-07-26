<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    final public function run(): void
    {
        if (Language::count() === 0) {
            Language::factory()->createMany([
                ['symbol' => 'is', 'name' => 'Icelandic'],
                ['symbol' => 'ua', 'name' => 'Ukrainian'],
                ['symbol' => 'en', 'name' => 'English'],
            ]);
        }
    }
}
