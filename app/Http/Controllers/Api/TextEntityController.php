<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadTextEntityRequest;
use App\Http\Requests\StoreTextEntityRequest;
use App\Http\Requests\UpdateTextEntityRequest;
use App\Http\Resources\TextEntityResource;
use App\Http\Services\TextEntityService;

class TextEntityController extends BaseApiController
{
    final protected function getService(): TextEntityService
    {
        return resolve(TextEntityService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreTextEntityRequest::class,
            'update' => UpdateTextEntityRequest::class,
            'index' => ReadTextEntityRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => ['topic', 'level', 'audioFile', 'words'],
            'show' => ['topic', 'level', 'audioFile', /*'readingProgress'*/],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return TextEntityResource::class;
    }
}
