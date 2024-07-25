<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseAudioFileRequest;
use App\Http\Requests\ReadAudioFileRequest;
use App\Http\Requests\StoreAudioFileRequest;
use App\Http\Requests\UpdateAudioFileRequest;
use App\Http\Resources\AudioFileResource;
use App\Http\Services\AudioFileService;

class AudioFileController  extends BaseApiController
{
    final protected function getService(): AudioFileService
    {
        return resolve(AudioFileService ::class);
    }

    final protected function getRequestClass(string $method): string
    {
        return match ($method) {
            'store' => StoreAudioFileRequest::class,
            'update' => UpdateAudioFileRequest::class,
            'index' => ReadAudioFileRequest::class,
            default => throw new \InvalidArgumentException("Unknown method for request class resolution"),
        };
    }

    final protected function getResourceClass(): string
    {
        return AudioFileResource::class;
    }
}
