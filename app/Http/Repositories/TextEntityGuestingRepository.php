<?php

namespace App\Http\Repositories;

use App\Models\TextEntityGuesting;

class TextEntityGuestingRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new TextEntityGuesting());
    }
}
