<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\TextEntityGuesting */
class TextEntityGuestingResource extends JsonResource
{
    final public function toArray(Request $request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'text_entity' => new TextEntityResource($this->whenLoaded('textEntity')),
        ]);
    }
}
