<?php

namespace App\Models\Relations;

use App\Models\Image;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WordImage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'word_image';

    protected $primaryKey = 'id';

    protected $fillable = [
        'word_id',
        'image_id',
    ];

    final public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_id');
    }

    final public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'image_id');
    }
}
