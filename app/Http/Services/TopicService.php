<?php

namespace App\Http\Services;

use App\Http\Repositories\TopicRepository;

class TopicService extends BaseService
{
    public function __construct(readonly protected TopicRepository $repository)
    {
    }
}
