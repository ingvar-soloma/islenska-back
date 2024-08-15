<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    final public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(5)->create();
        }
    }
}
