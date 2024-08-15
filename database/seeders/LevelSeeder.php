<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    final public function run(): void
    {
        if (Level::count() === 0) {
            Level::factory()->createMany([
                ['name' => 'A1.1',],
                ['name' => 'A1.2',],
                ['name' => 'A2.3',],
                ['name' => 'A2.4',],
            ]);
        }
    }
}
