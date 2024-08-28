<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\Relations\WordTextEntity;
use App\Models\TextEntity;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WordSeeder extends Seeder
{
    final public function run(): void
    {
        if (Word::count() === 0) {
//            $languageId = Language::where('symbol', '!=', 'is')->first()->id;
//            Word::factory()->count(50)->create(['language_id' => $languageId]);
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
        $existingWords = Word::whereIn('name', array_column($wordsData, 'name'))
            ->whereIn('language_id', array_column($wordsData, 'language_id'))
            ->select('name', 'language_id')
            ->get()
            ->toArray();

        $newWordsData = array_filter($wordsData, function ($wordData) use ($existingWords) {
            foreach ($existingWords as $existingWord) {
                if ($existingWord['name'] === $wordData['name'] && $existingWord['language_id'] === $wordData['language_id']) {
                    return false;
                }
            }
            return true;
        });

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
