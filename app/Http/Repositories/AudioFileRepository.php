<?php

namespace App\Http\Repositories;

use App\Models\AudioFile;

class AudioFileRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new AudioFile());
    }
}
