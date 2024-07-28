<?php

namespace App\Policies;

use App\Models\TextEntity;
use App\Models\User;

class TextEntityPolicy
{
    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, TextEntity $textEntity): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, TextEntity $textEntity): bool
    {
        return false;
    }

    final public function delete(User $user, TextEntity $textEntity): bool
    {
        return false;
    }

    final public function restore(User $user, TextEntity $textEntity): bool
    {
        return false;
    }

    final public function forceDelete(User $user, TextEntity $textEntity): bool
    {
        return false;
    }
}

