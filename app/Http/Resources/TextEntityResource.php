<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TextEntityResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'audio_file' => $this->whenLoaded('audioFile', function () {
                return new AudioFileResource($this->audioFile);
            })
        ]);
    }
}
