<?php

namespace Database\Seeders;

use App\Models\AudioFile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class AudioFileSeeder extends Seeder
{
    final public function run(): void
    {
        $files = File::files(storage_path(AudioFile::FILE_PATH));
        $fileNames = array_map(fn($file) => $file->getFilename(), $files);

        $existingFileNames = AudioFile::whereIn('file_name', $fileNames)->pluck('file_name')->toArray();
        $newFileNames = array_diff($fileNames, $existingFileNames);

        AudioFile::factory()->createMany(array_map(fn($fileName) => [
            'file_name' => $fileName,
        ], $newFileNames));
    }
}
