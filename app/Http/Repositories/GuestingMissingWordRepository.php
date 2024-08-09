<?php

namespace App\Http\Repositories;

use App\Models\GuestingMissingWord;

class GuestingMissingWordRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new GuestingMissingWord());
    }
}
