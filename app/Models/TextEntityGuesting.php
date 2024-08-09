<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
