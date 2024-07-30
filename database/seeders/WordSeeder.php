<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Relations\WordTextEntity;
use App\Models\TextEntity;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WordSeeder extends Seeder
{
    final public function run(): void
    {
        if (Word::count() === 0) {
            $languageId = Language::where('symbol', '!=', 'is')->first()->id;
            Word::factory()->count(50)->create(['language_id' => $languageId]);
        }

        $textEntities = TextEntity::all();

        $wordsData = [];

        foreach ($textEntities as $textEntity) {
            $textWords = preg_split('/([^a-zA-ZáðéíóúýþæöÁÐÉÍÓÚÝÞÆÖ]+)/', $textEntity->text, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($textWords as $word) {
                if (preg_match('/^[\wáðéíóúýþæöÁÐÉÍÓÚÝÞÆÖ]+$/i', $word)) {
                    $wordsData[] = ["name" => Str::lower($word), "language_id" => $textEntity['language_id']];
                }
            }
        }


        $wordsData = array_map("unserialize", array_unique(array_map("serialize", $wordsData)));
        $existingWords = Word::whereIn('name', array_column($wordsData, 'name'))->select('name')->pluck('name')->toArray();
        $newWordsData = array_filter($wordsData, fn($wordData) => !in_array($wordData['name'], $existingWords));

        $words = Word::factory()->createMany($newWordsData);

        $wordTextEntityData = [];
        foreach ($words as $word) {
            foreach ($textEntities as $textEntity) {
                if (str_contains(Str::lower($textEntity['text']), $word['name'])) {
                    $wordTextEntityData[] = [
                        'word_id' => $word['id'],
                        'text_entity_id' => $textEntity['id'],
                    ];
                }
            }
        }

        WordTextEntity::insert($wordTextEntityData);
    }
}
