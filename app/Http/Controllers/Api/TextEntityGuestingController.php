<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadTextEntityGuestingRequest;
use App\Http\Requests\StoreTextEntityGuestingRequest;
use App\Http\Requests\UpdateTextEntityGuestingRequest;
use App\Http\Resources\TextEntityGuestingResource;
use App\Http\Services\TextEntityGuestingService;

class TextEntityGuestingController extends BaseApiController
{
    final protected function getService(): TextEntityGuestingService
    {
        return resolve(TextEntityGuestingService::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreTextEntityGuestingRequest::class,
            'update' => UpdateTextEntityGuestingRequest::class,
            'index' => ReadTextEntityGuestingRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => ['textEntity', 'words'],
            'show' => ['textEntity', 'words'],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return TextEntityGuestingResource::class;
    }
}
