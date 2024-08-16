<?php

namespace Database\Seeders;

use App\Models\GuestingMissingWord;
use App\Models\TextEntity;
use Illuminate\Database\Seeder;

class TextEntityGuestingSeeder extends Seeder
{
    final public function run(): void
    {
        $textEntities = TextEntity::all();

        $textEntities->each(function (TextEntity $textEntity) {
            if ($textEntity->guestings()->doesntExist()) {
                $guesting = $textEntity->guestings()->create();

                $words = $textEntity->words();
                $wordCount = $words->count();
                $missingWordsCount = random_int(1, intval(max(1,$wordCount/2)));

                $uniqueWords = $words->take($missingWordsCount)->get();

                $uniqueWords->each(function ($word) use ($guesting) {
                    GuestingMissingWord::factory()->create([
                        'text_entity_guesting_id' => $guesting->id,
                        'word_id' => $word->id,
                    ]);
                });
            }
        });
    }
}
