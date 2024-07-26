<?php

namespace Database\Seeders;

use App\Http\Services\AudioFileService;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    final public function run(): void
    {
        // User::factory(10)->create();

//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);

            $this->call([
                AudioFileSeeder::class,
                LanguageSeeder::class,
                LevelSeeder::class,
                TopicSeeder::class,
                WordSeeder::class,
            ]);
    }
}
