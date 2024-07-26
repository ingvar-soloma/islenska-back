<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\ReadTopicRequest;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use App\Http\Resources\TopicResource;
use App\Http\Services\TopicService;

class TopicController extends BaseApiController
{
    final protected function getService(): TopicService
    {
        return resolve(TopicService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreTopicRequest::class,
            'update' => UpdateTopicRequest::class,
            'index' => ReadTopicRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return TopicResource::class;
    }
}
