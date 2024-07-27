<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AudioFileResource extends JsonResource
{
    final public function toArray($request): array
    {
        $data = parent::toArray($request);

        return array_merge($data, [
            'file_name_without_extension' => $this->file_name_without_extension,
        ]);
    }
}
