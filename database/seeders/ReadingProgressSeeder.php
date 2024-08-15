<?php

namespace Database\Seeders;

use App\Models\ReadingProgress;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReadingProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    final public function run(): void
    {
        ReadingProgress::factory()->count(10)->create();
    }
}
