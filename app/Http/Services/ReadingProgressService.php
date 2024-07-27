<?php

namespace App\Http\Services;

use App\Http\Repositories\ReadingProgressRepository;

class ReadingProgressService extends BaseService
{
    public function __construct(readonly protected ReadingProgressRepository $repository)
    {
    }
}
