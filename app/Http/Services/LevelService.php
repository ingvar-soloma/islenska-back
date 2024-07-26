<?php

namespace App\Http\Services;


use App\Http\Repositories\LevelRepository;

class LevelService extends BaseService
{
    public function __construct(readonly protected LevelRepository $repository)
    {
    }
}
