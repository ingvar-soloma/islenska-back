<?php

namespace App\Models\Relations;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'translation_id',
        'is_public',
    ];

    protected $casts = [
        'is_public' => 'boolean',
    ];

    protected $attributes = [
        'is_public' => false,
    ];

    final public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    final public function translation(): BelongsTo
    {
        return $this->belongsTo(Translation::class);
    }

    public function makePublic(): self
    {
        $this->is_public = true;
        $this->save();
        return $this;
    }

    public function makePrivate(): self
    {
        $this->is_public = false;
        $this->save();
        return $this;
    }
}
