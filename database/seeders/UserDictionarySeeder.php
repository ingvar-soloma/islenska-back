<?php

namespace Database\Seeders;

use App\Models\UserDictionary;
use Illuminate\Database\Seeder;

class UserDictionarySeeder extends Seeder
{
    final public function run(): void
    {
        UserDictionary::factory()->count(10)->create();
    }
}
