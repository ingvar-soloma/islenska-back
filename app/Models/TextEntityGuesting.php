<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class TextEntityGuesting extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_entity_id',
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    final public function textEntity(): BelongsTo
    {
        return $this->belongsTo(TextEntity::class);
    }

    final public function guestingMissingWords(): HasMany
    {
        return $this->hasMany(GuestingMissingWord::class);
    }

    final public function words(): HasManyThrough
    {
        return $this->hasManyThrough(
            Word::class,
            GuestingMissingWord::class,
            'text_entity_guesting_id',
            'id',
            'id',
            'word_id'
        );
    }
}
