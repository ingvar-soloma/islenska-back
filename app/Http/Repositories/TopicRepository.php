<?php

namespace App\Http\Repositories;

use App\Models\Topic;

class TopicRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Topic());
    }
}
