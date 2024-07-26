<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    final public function run(): void
    {
        if (Word::count() === 0) {
            Word::factory()->count(50)->create();
        }
    }
}
