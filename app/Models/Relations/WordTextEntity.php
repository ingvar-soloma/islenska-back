<?php

namespace App\Models\Relations;

use App\Models\TextEntity;
use App\Models\Word;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordTextEntity extends Model
{
    public $timestamps = false;
    protected $table = 'word_text_entity';

    protected $fillable = [
        'word_id',
        'text_entity_id',
    ];

    final public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    final public function textEntity(): BelongsTo
    {
        return $this->belongsTo(TextEntity::class);
    }
}
