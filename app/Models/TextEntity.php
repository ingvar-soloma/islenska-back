<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TextEntity extends Model
{
    use HasFactory;

    protected $table = 'text_entities';

    protected $primaryKey = 'id';

    protected $fillable = [
        'text',
        'level_id',
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

    final public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    final public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    final public function audioFile(): BelongsTo
    {
        return $this->belongsTo(AudioFile::class);
    }
}
