<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TextEntityResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, []);
    }
}
