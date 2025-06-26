<?php

namespace App\Http\Services;

use App\Http\Repositories\UserTranslationRepository;

class UserTranslationService extends BaseService
{
    public function __construct(readonly protected UserTranslationRepository $repository)
    {
    }
}
