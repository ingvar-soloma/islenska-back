<?php

namespace App\Http\Services;

use App\Http\Repositories\AudioFileRepository;

class AudioFileService extends BaseService
{
    public function __construct(readonly protected AudioFileRepository $repository)
    {
    }
}
