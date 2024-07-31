<?php

namespace App\Http\Services;

use App\Http\Repositories\UserDictionaryRepository;

class UserDictionaryService extends BaseService
{

    public function __construct(readonly protected UserDictionaryRepository $repository)
    {
    }
}
