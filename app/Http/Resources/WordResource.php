<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WordResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        $data['translations'] = $this->whenLoaded('translationsFrom', function () {
            if ($this->resource->relationLoaded('translationsFrom') && $this->resource->relationLoaded('translationsTo')) {
                return $this->resource->mergedTranslations();
            }
            return null;
        });
        unset($data['translations_to']);
        unset($data['translations_from']);

        return array_merge($data, []);
    }
}
