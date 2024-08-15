<?php

namespace App\Models;

use App\Models\Relations\Translation;
use App\Models\Relations\WordTextEntity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language_id',
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

    final public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    final public function mergedTranslations($translationsFrom, $translationsTo): Collection
    {
        return $translationsFrom->merge($translationsTo);
    }

    final public function translationsTo(): BelongsToMany
    {
        return $this->belongsToMany(
            Word::class,
            'translations',
            'word_from_id',
            'word_to_id'
        );
    }

    final public function translationsFrom(): BelongsToMany
    {
        return $this->belongsToMany(
            Word::class,
            'translations',
            'word_to_id',
            'word_from_id'
        );
    }

    final public function wordTextEntities(): HasMany
    {
        return $this->hasMany(WordTextEntity::class);
    }
}
