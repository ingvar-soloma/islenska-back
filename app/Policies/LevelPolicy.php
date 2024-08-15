<?php

namespace App\Policies;

use App\Models\Level;
use App\Models\User;

class LevelPolicy
{
    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, Level $level): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, Level $level): bool
    {
        return false;
    }

    final public function delete(User $user, Level $level): bool
    {
        return false;
    }

    final public function restore(User $user, Level $level): bool
    {
        return false;
    }

    final public function forceDelete(User $user, Level $level): bool
    {
        return false;
    }
}
