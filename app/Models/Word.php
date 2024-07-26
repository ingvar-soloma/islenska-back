<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\Collection;

class Word extends Model
{
    use HasFactory;

    protected $table = 'words';

    protected $fillable = [
        'name',
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

    final public function translationsFrom(): HasManyThrough
    {
        return $this->hasManyThrough(
            Word::class,
            Translation::class,
            'word_from_id',
            'id',
            'id',
            'word_to_id'
        );
    }

    final public function translationsTo(): HasManyThrough
    {
        return $this->hasManyThrough(
            Word::class,
            Translation::class,
            'word_to_id',
            'id',
            'id',
            'word_from_id'
        );
    }

    final public function mergedTranslations(): Collection
    {
        $translationsFrom = $this->translationsFrom()->get();
        $translationsTo = $this->translationsTo()->get();

        return $translationsFrom->merge($translationsTo);
    }

    final public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }
}
