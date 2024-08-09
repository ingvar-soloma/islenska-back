<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\GuestingMissingWord */
class GuestingMissingWordResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'word' => new WordResource($this->whenLoaded('word')),
            'textEntitiesGuesting' => new TextEntityGuestingResource($this->whenLoaded('textEntitiesGuesting')),
        ]);
    }
}
