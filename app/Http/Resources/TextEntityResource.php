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
            'audio_file' => new AudioFileResource($this->whenLoaded('audioFile')),
            'words' => WordResource::collection($this->whenLoaded('words')),
        ]);
    }
}
