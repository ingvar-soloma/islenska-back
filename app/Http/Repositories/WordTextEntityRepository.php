<?php

namespace App\Http\Repositories;

use App\Models\Relations\WordTextEntity;

class WordTextEntityRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new WordTextEntity());
    }
}
