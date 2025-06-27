<?php

namespace App\Models\Relations;

use App\Models\User;
use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Translation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'translations';

    protected $primaryKey = 'id';

    protected $fillable = [
        'word_to_id',
        'word_from_id',
        'quality',
    ];

    final public function wordFrom(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_from_id');
    }

    final public function wordTo(): BelongsTo
    {
        return $this->belongsTo(Word::class, 'word_to_id');
    }

    final public function userTranslations(): HasMany
    {
        return $this->hasMany(UserTranslation::class, 'translation_id');
    }

    final public function users()
    {
        return $this->belongsToMany(User::class, 'user_translations', 'translation_id', 'user_id')
                    ->withPivot('is_public');
    }

    public function isPublic(): bool
    {
        return $this->userTranslations()->where('is_public', true)->exists();
    }
}
