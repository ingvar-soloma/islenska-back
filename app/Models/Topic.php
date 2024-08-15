<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'level_id',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    final public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    final public function textEntities(): HasMany
    {
        return $this->hasMany(TextEntity::class);
    }

}
