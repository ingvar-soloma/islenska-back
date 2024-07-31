<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadUserDictionaryRequest;
use App\Http\Requests\StoreUserDictionaryRequest;
use App\Http\Requests\UpdateUserDictionaryRequest;
use App\Http\Resources\UserDictionaryResource;
use App\Http\Services\UserDictionaryService;

class UserDictionaryController extends BaseApiController
{
    final protected function getService(): UserDictionaryService
    {
        return resolve(UserDictionaryService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreUserDictionaryRequest::class,
            'update' => UpdateUserDictionaryRequest::class,
            'index' => ReadUserDictionaryRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => [],
            'show' => [],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return UserDictionaryResource::class;
    }
}
