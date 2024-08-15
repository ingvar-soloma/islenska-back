<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDictionary extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'word_id',
        'level_of_knowing',
        'stability',
        'created_at',
        'updated_at'
    ];


    final public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
