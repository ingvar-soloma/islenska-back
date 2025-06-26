<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'translation_id',
    ];

    final public function user(): User
    {
        return $this->belongsTo(User::class);
    }

    final public function translation(): Translation
    {
        return $this->belongsTo(Translation::class);
    }
}

