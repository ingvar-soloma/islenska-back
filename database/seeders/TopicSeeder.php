<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    final public function run(): void
    {
        $topics = [
            '1. Hvað heitir þú?',
            '2. Hvaðan ert þú?',
            '3. Komdu sæll',
            '4. Hvað segir þú gott?',
//            '5. Hvað er að frétta?',
//            '6. Hvað er nýtt?',
//            '7. Hvað er í gangi?',

        ];

        if (Topic::count() === 0) {
            Topic::factory()->createMany(array_map(fn($topic) => [
                'name' => $topic,
            ], $topics));
        }
    }
}
