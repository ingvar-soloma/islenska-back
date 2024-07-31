<?php

namespace App\Http\Repositories;

use App\Models\UserDictionary;

class UserDictionaryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new UserDictionary());
    }
}
