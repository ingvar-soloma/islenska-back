<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseApiController;
use App\Http\Requests\ReadWordRequest;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Requests\WordRequest;
use App\Http\Resources\WordResource;
use App\Models\Word;
use App\Http\Services\WordService;

class WordController extends BaseApiController
{
    final protected function getService(): WordService
    {
        return resolve(WordService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreWordRequest::class,
            'update' => UpdateWordRequest::class,
            'index' => ReadWordRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => [],
            'show' => ['language', 'translationsFrom', 'translationsTo'],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return WordResource::class;
    }
}
