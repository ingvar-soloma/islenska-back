<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\TextEntity */
class TextEntityResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'audio_file' => $this->whenLoaded('audioFile', function () {
                return new AudioFileResource($this->audioFile);
            }),
            'words' => $this->whenLoaded('words', function () {
                return WordResource::collection($this->words);
            }),
        ]);
    }
}
