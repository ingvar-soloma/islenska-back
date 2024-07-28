<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait HasOwner
{
    final public function isOwner(User $user, Model $model): bool
    {
        return $model->user_id === $user->id;
    }
}
