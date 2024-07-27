<?php

namespace Database\Seeders;

use App\Models\AudioFile;
use App\Models\TextEntity;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class TextEntitySeeder extends Seeder
{
    /**
     * @var mixed[]
     */
    private static ?Collection $audioFiles = null;

    final public function run(): void
    {
        self::$audioFiles = AudioFile::all();
        self::$audioFiles = self::$audioFiles->mapWithKeys(function (AudioFile $audioFile) {
            return [$audioFile->file_name_without_extension => ['id' => $audioFile->id]];
        });

        $json = File::get(base_path('storage/app/texts/book.json'));
        $data = json_decode($json, true);

        $textEntities = [];
        $topicNames = array_keys($data);

        $topicsCollection = $this->createOrGetTopics($topicNames);

        foreach ($data as $topic_name => $texts) {
            foreach ($texts as $item) {
                $textEntities[] = [
                    'topic_id' => $topicsCollection->firstWhere('name', $topic_name)->id,
                    'text' => $item['text'],
                    'audio_file_id' => $this->getAudioFileId($item['audioFile']),
                ];
            }
        }

        TextEntity::factory()->createMany($textEntities);
    }

    private function getAudioFileId(mixed $audioFile): ?int
    {
        return self::$audioFiles->get($audioFile)['id'] ?? null;
    }

    private function createOrGetTopics(array $topicNames): Collection
    {

        $existingTopics = Topic::whereIn('name', $topicNames)->get();
        $existingTopicNames = $existingTopics->pluck('name')->toArray();
        $newTopicNames = array_diff($topicNames, $existingTopicNames);

        if (!empty($newTopicNames)) {
            $newTopics = Topic::factory()->createMany(array_map(fn($name) => ['name' => $name], $newTopicNames));
            $existingTopics = $existingTopics->merge($newTopics);
        }

        return $existingTopics;
    }
}
