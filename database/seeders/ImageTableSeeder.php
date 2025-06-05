<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Language;
use App\Models\Relations\WordImage;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ImageTableSeeder extends Seeder
{
    final public function run(): void
    {
        $files = File::files(storage_path(Image::FILE_PATH));
        $fileNames = array_map(fn($file) => $file->getFilename(), $files);
        $fileNamesWithoutExtension = array_map(fn($fileName) => pathinfo($fileName, PATHINFO_FILENAME), $fileNames);

        $existingFileNames = Image::whereIn('file_name', $fileNames)->pluck('file_name')->toArray();
        $newFileNames = array_diff($fileNames, $existingFileNames);

        $images = Image::factory()->createMany(array_map(fn($fileName) => [
            'file_name' => $fileName,
        ], $newFileNames));

        $existingWords = Word::select(['id', 'name'])->whereIn('name', $fileNamesWithoutExtension)->get();
        $wordsToCreate = array_diff($fileNamesWithoutExtension, $existingWords->pluck('name')->toArray());
        if (!empty($wordsToCreate)) {
            $languageId = Language::where('symbol', Language::IS)->first()->id;

            $newWords = Word::factory()->createMany(array_map(fn($word) => [
                'name' => $word,
                'language_id' => $languageId
            ], $wordsToCreate));
        }

        $allWords = $existingWords->merge($newWords ?? collect());
        $wordImagePairs = collect();
        // prepare pairs image word to insert into pivot table
        foreach ($images as $image) {
            $wordName = pathinfo($image->file_name, PATHINFO_FILENAME);
            $word = $allWords->firstWhere('name', $wordName);

            if ($word) {
                $wordImagePairs->push([
                    'word_id' => $word->id,
                    'image_id' => $image->id
                ]);
            }
        }

        if ($wordImagePairs->isNotEmpty()) {
//            WordImage::factory()->createMany($wordImagePairs->toArray());
            \DB::table((new WordImage())->getTable())->insert($wordImagePairs->toArray());
        }
    }

    final public function run2(): void
    {
        $files = File::files(storage_path(Image::FILE_PATH));
        $fileNames = array_map(fn($file) => $file->getFilename(), $files);
        $fileNamesWithoutExtension = array_map(fn($fileName) => pathinfo($fileName, PATHINFO_FILENAME), $fileNames);
        $images = Image::all();

        $existingWords = Word::select(['id', 'name'])->whereIn('name', $fileNamesWithoutExtension)->get();
        $wordsToCreate = array_diff($fileNamesWithoutExtension, $existingWords->pluck('name')->toArray());
        if (!empty($wordsToCreate)) {
            $languageId = Language::where('symbol', Language::IS)->first()->id;

            $newWords = Word::factory()->createMany(array_map(fn($word) => [
                'name' => $word,
                'language_id' => $languageId
            ], $wordsToCreate));
        }

        $allWords = $existingWords->merge($newWords ?? collect());
        $wordImagePairs = collect();
        // prepare pairs image word to insert into pivot table
        dump($images);
        foreach ($images as $image) {
            $wordName = pathinfo($image->file_name, PATHINFO_FILENAME);
            $word = $allWords->firstWhere('name', $wordName);

            if ($word) {
                $wordImagePairs->push([
                    'word_id' => $word->id,
                    'image_id' => $image->id
                ]);
            }

            dump("Image: {$image->file_name}, Word: {$wordName}, Word ID: {$word->id}");
        }

        if ($wordImagePairs->isNotEmpty()) {
            \DB::table((new WordImage())->getTable())->insert($wordImagePairs->toArray());
        }
    }
}
