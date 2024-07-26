<?php

namespace App\Http\Repositories;

use App\Models\Translation;

class TranslationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Translation());
    }
}
