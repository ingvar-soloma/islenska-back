<?php

namespace App\Http\Services;

use App\Http\Repositories\GuestingMissingWordRepository;

class GuestingMissingWordService extends BaseService
{
    public function __construct(protected GuestingMissingWordRepository $repository)
    {
    }
}
