<?php

namespace App\Http\Services;

use App\Http\Repositories\LanguageRepository;

class LanguageService extends BaseService
{
    public function __construct(readonly protected LanguageRepository $repository)
    {
    }
}
