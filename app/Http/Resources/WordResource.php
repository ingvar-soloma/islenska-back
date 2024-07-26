<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class WordResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        $mergedTranslations = $this->resource->mergedTranslations();

        $data['translations'] = $mergedTranslations->isNotEmpty() ? $mergedTranslations : new MissingValue;
        unset($data['translations_to']);
        unset($data['translations_from']);

        return array_merge($data, []);
    }
}
