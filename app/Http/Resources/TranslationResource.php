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
            'word_from' => $this->whenLoaded('wordFrom', function () {
                return new WordResource($this->wordFrom);
            }),
            'word_to' => $this->whenLoaded('wordTo', function () {
                return new WordResource($this->wordTo);
            }),
        ]);
    }
}

