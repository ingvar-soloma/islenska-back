<?php

namespace Database\Seeders;

use App\Http\Services\AudioFileService;
use App\Models\ReadingProgress;
use App\Models\TextEntity;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    final public function run(): void
    {

            $this->call([
                UserSeeder::class,
                LanguageSeeder::class,
                WordSeeder::class,
//                TopicSeeder::class,
//                LevelSeeder::class,
                AudioFileSeeder::class,
                TextEntitySeeder::class,
                TranslationSeeder::class,
                ReadingProgressSeeder::class,
            ]);
    }
}
