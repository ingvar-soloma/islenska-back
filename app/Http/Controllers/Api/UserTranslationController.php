<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreUserTranslationRequest;
use App\Http\Requests\UpdateUserTranslationRequest;
use App\Http\Requests\ReadUserTranslationRequest;
use App\Http\Resources\UserTranslationResource;
use App\Http\Services\UserTranslationService;

class UserTranslationController extends BaseApiController
{
    final protected function getService(): UserTranslationService
    {
        return resolve(UserTranslationService::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreUserTranslationRequest::class,
            'update' => UpdateUserTranslationRequest::class,
            'index' => ReadUserTranslationRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return UserTranslationResource::class;
    }
}
