<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Cache;

class Translation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'translations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'word_to_id',
        'word_from_id',
    ];

    final public function wordFrom(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_from_id');
    }

    final public function wordTo(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_to_id');
    }
}
