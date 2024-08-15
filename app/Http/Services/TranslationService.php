<?php

namespace App\Http\Services;

use App\Http\Repositories\TranslationRepository;

class TranslationService extends BaseService
{
    public function __construct(readonly protected TranslationRepository $repository)
    {
    }
}
