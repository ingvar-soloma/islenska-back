<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Level */

class LevelResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);


        return array_merge($data, [
            'topic_count' => $this->whenLoaded('topics', function () {
                return $this->topics()->has('textEntities')->count();
            }),
        ]);
    }
}
