<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestingMissingWord extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'text_entities_guesting_id',
        'word_id',
    ];

    final public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    final public function textEntitiesGuesting(): BelongsTo
    {
        return $this->belongsTo(TextEntityGuesting::class);
    }
}
