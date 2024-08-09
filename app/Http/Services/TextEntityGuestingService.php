<?php

namespace App\Http\Services;

use App\Http\Repositories\TextEntityGuestingRepository;

class TextEntityGuestingService extends BaseService
{
    public function __construct(readonly protected TextEntityGuestingRepository $repository)
    {
    }
}
