<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadLanguageRequest;
use App\Http\Requests\StoreLanguageRequest;
use App\Http\Requests\UpdateLanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Http\Services\LanguageService;

class LanguageController extends BaseApiController
{
    final protected function getService(): LanguageService
    {
        return resolve(LanguageService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreLanguageRequest::class,
            'update' => UpdateLanguageRequest::class,
            'index' => ReadLanguageRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return LanguageResource::class;
    }
}
