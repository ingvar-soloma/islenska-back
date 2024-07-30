<?php

namespace App\Http\Repositories;

use App\Models\Relations\Translation;

class TranslationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Translation());
    }
}
