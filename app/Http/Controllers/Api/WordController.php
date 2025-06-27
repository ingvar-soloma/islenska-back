<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadWordRequest;
use App\Http\Requests\StoreWordRequest;
use App\Http\Requests\UpdateWordRequest;
use App\Http\Resources\WordResource;
use App\Http\Services\WordService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

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
            'index' => ['translationsFrom', 'translationsTo', 'images'],
            'show' => ['language', 'translationsFrom', 'translationsTo'],
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return WordResource::class;
    }

    final public function store(Request $request): JsonResponse
    {
        if (isset($request['translation_id'])) {
            Gate::authorize('translate', $this->service->getModel());
        }

        return parent::store($request);
    }
}
