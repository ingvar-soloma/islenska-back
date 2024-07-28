<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Level extends Model
{
    use HasFactory;

    protected $table = 'levels';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // Default attribute values
    protected $attributes = [
        'created_at' => null,
        'updated_at' => null
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    final public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }

    final public function textEntities(): HasManyThrough
    {
        return $this->hasManyThrough(TextEntity::class, Topic::class);
    }
}
