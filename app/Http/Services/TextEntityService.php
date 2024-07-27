<?php

namespace App\Http\Services;

use App\Http\Repositories\TextEntityRepository;

class TextEntityService extends BaseService
{
    public function __construct(readonly protected TextEntityRepository $repository)
    {
    }
}
