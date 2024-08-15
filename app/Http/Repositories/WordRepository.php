<?php

namespace App\Http\Repositories;

use App\Models\Word;

class WordRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Word());
    }
}
