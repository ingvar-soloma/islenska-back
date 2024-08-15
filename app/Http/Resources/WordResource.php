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
                return $this->resource->mergedTranslations(
                    $this->resource->translationsFrom,
                    $this->resource->translationsTo
                );
            }
            return null;
        });
        unset($data['translations_to'], $data['translations_from']);

        return array_merge($data, []);
    }
}
