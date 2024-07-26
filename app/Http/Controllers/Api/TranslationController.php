<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadTranslationRequest;
use App\Http\Requests\StoreTranslationRequest;
use App\Http\Requests\UpdateTranslationRequest;
use App\Http\Resources\TranslationResource;
use App\Http\Services\TranslationService;
use App\Models\Language;
use App\Models\Word;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class TranslationController extends BaseApiController
{
    final protected function getService(): TranslationService
    {
        return resolve(TranslationService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreTranslationRequest::class,
            'update' => UpdateTranslationRequest::class,
            'index' => ReadTranslationRequest::class,
            default => throw new InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getRelations(string $method): array
    {
        return match ($method) {
            'update' => [],
            'store' => [],
            'index' => [],
            'show' => ['wordFrom', 'wordTo'],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return TranslationResource::class;
    }
}
