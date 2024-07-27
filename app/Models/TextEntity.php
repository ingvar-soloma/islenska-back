<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class TextEntity extends Model
{
    use HasFactory;

    protected $table = 'text_entities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'text',
        'topic_id',
        'audio_file_id',
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

    final public function level(): HasOneThrough
    {
        return $this->hasOneThrough(Level::class, Topic::class, 'id', 'id', 'topic_id', 'level_id');
    }

    final public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    final public function audioFile(): BelongsTo
    {
        return $this->belongsTo(AudioFile::class);
    }

    final public function readingProgress(): HasOne
    {
        return $this->hasOne(ReadingProgress::class);
    }
}
