<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Relations\Translation */
class TranslationResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'word_from' => new WordResource($this->whenLoaded('word_from')),
            'word_to' => new WordResource($this->whenLoaded('word_to')),
        ]);
    }
}

