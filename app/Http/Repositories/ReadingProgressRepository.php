<?php

namespace App\Http\Repositories;

use App\Models\ReadingProgress;

class ReadingProgressRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new ReadingProgress());
    }
}
