<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreGuestingMissingWordRequest;
use App\Http\Requests\UpdateGuestingMissingWordRequest;
use App\Http\Requests\ReadGuestingMissingWordRequest;
use App\Http\Resources\GuestingMissingWordResource;
use App\Http\Services\GuestingMissingWordService;

class GuestingMissingWordController extends BaseApiController
{
    final protected function getService(): GuestingMissingWordService
    {
        return resolve(GuestingMissingWordService::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreGuestingMissingWordRequest::class,
            'update' => UpdateGuestingMissingWordRequest::class,
            'index' => ReadGuestingMissingWordRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return GuestingMissingWordResource::class;
    }

}
