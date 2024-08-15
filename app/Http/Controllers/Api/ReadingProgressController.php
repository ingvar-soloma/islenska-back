<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadReadingProgressRequest;
use App\Http\Requests\StoreReadingProgressRequest;
use App\Http\Requests\UpdateReadingProgressRequest;
use App\Http\Resources\ReadingProgressResource;
use App\Models\ReadingProgress;
use App\Http\Services\ReadingProgressService;
use Illuminate\Http\JsonResponse;

class ReadingProgressController extends BaseApiController
{
    final protected function getService(): ReadingProgressService
    {
        return resolve(ReadingProgressService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreReadingProgressRequest::class,
            'update' => UpdateReadingProgressRequest::class,
            'index' => ReadReadingProgressRequest::class,
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
        return ReadingProgressResource::class;
    }
}
