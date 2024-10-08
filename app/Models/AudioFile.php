<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AudioFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'created_at',
        'updated_at',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public const FILE_PATH = 'app/public/audio';

    public function getFileNameWithoutExtensionAttribute(): string
    {
        return pathinfo($this->file_name, PATHINFO_FILENAME);
    }
}
