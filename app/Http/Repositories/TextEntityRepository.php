<?php

namespace App\Http\Repositories;

use App\Models\TextEntity;

class TextEntityRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new TextEntity);
    }
}
