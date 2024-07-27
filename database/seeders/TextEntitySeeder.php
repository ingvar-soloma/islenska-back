<?php

namespace Database\Seeders;

use App\Models\AudioFile;
use App\Models\Level;
use App\Models\TextEntity;
use App\Models\Topic;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class TextEntitySeeder extends Seeder
{
    private static ?Collection $audioFiles = null;

    final public function run(): void
    {
        self::$audioFiles = AudioFile::all();
        self::$audioFiles = self::$audioFiles->mapWithKeys(function (AudioFile $audioFile) {
            return [$audioFile->file_name_without_extension => ['id' => $audioFile->id]];
        });

        $json = File::get(base_path('storage/app/texts/book.json'));
        $data = json_decode($json, true);

        $levelNames = array_keys($data);
        $levelCollection = $this->createOrGetLevels($levelNames);

        $textEntities = [];
        $topicsData = [];

        foreach ($data as $levelName => $topics) {
            $levelId = $levelCollection->firstWhere('name', $levelName)->id;
            foreach ($topics as $topicName => $texts) {
                $topicsData[] = ['name' => $topicName, 'level_id' => $levelId];
            }
        }

        $topicsCollection = $this->createOrGetTopics($topicsData);

        foreach ($data as $levelName => $topics) {
            foreach ($topics as $topicName => $texts) {
                foreach ($texts as $item) {
                    $textEntities[] = [
                        'topic_id' => $topicsCollection->firstWhere('name', $topicName)->id,
                        'text' => $item['text'],
                        'audio_file_id' => $this->getAudioFileId($item['audioFile']),
                    ];
                }
            }
        }

        TextEntity::factory()->createMany($textEntities);
    }

    private function createOrGetLevels(array $levelNames): Collection
    {
        $existingLevels = Level::whereIn('name', $levelNames)->get();
        $existingLevelNames = $existingLevels->pluck('name')->toArray();
        $newLevelNames = array_diff($levelNames, $existingLevelNames);

        if (!empty($newLevelNames)) {
            $newLevels = Level::factory()->createMany(array_map(fn($name) => ['name' => $name], $newLevelNames));
            $existingLevels = $existingLevels->merge($newLevels);
        }

        return $existingLevels;
    }

    private function createOrGetTopics(array $topicsData): Collection
    {
        $topicNames = array_column($topicsData, 'name');
        $existingTopics = Topic::whereIn('name', $topicNames)->get();
        $existingTopicNames = $existingTopics->pluck('name')->toArray();
        $newTopicsData = array_filter($topicsData, fn($topic) => !in_array($topic['name'], $existingTopicNames));

        if (!empty($newTopicsData)) {
            $newTopics = Topic::factory()->createMany($newTopicsData);
            $existingTopics = $existingTopics->merge($newTopics);
        }

        return $existingTopics;
    }

    private function getAudioFileId(mixed $audioFile): ?int
    {
        return self::$audioFiles->get($audioFile)['id'] ?? null;
    }
}
