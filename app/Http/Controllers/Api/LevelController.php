<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadLevelRequest;
use App\Http\Requests\StoreLevelRequest;
use App\Http\Requests\UpdateLevelRequest;
use App\Http\Resources\LevelResource;
use App\Http\Services\LevelService;

class LevelController extends BaseApiController
{
    final protected function getService(): LevelService
    {
        return resolve(LevelService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreLevelRequest::class,
            'update' => UpdateLevelRequest::class,
            'index' => ReadLevelRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return LevelResource::class;
    }
}
