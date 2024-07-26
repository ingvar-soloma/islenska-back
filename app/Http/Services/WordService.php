<?php

namespace App\Http\Services;

use App\Http\Repositories\WordRepository;

class WordService extends BaseService
{
    public function __construct(readonly protected WordRepository $repository)
    {
    }
}
