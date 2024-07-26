<?php

namespace App\Http\Repositories;

use App\Models\Level;

class LevelRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Level());
    }
}
