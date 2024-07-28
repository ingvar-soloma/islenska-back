<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Word;

class WordPolicy
{
    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, Word $word): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, Word $word): bool
    {
        return false;
    }

    final public function delete(User $user, Word $word): bool
    {
        return false;
    }

    final public function restore(User $user, Word $word): bool
    {
        return false;
    }

    final public function forceDelete(User $user, Word $word): bool
    {
        return false;
    }
}
