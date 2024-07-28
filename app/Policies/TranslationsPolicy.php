<?php

namespace App\Policies;

use App\Models\Translation;
use App\Models\User;

class TranslationsPolicy
{
    final public function viewAny(User $user): bool
    {
        return false;
    }

    final public function view(User $user, Translation $translations): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, Translation $translations): bool
    {
        return false;
    }

    final public function delete(User $user, Translation $translations): bool
    {
        return false;
    }

    final public function restore(User $user, Translation $translations): bool
    {
        return false;
    }

    final public function forceDelete(User $user, Translation $translations): bool
    {
        return false;
    }
}
