<?php

namespace App\Http\Repositories;

use App\Models\Language;

class LanguageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Language());
    }
}
