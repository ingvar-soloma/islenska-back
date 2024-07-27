<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class TextEntityResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'audio_file' => new AudioFileResource($this->audioFile ?? new MissingValue()),
        ]);
    }
}
