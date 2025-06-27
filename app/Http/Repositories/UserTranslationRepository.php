<?php

namespace App\Http\Repositories;

use App\Models\Relations\UserTranslation;

class UserTranslationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new UserTranslation());
    }
}
