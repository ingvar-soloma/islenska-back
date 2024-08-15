<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadingProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'text_entity_id',
        'user_id',
        'read',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'read' => 'boolean'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    final public function textEntity(): BelongsTo
    {
        return $this->belongsTo(TextEntity::class);
    }

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
