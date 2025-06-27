<?php

namespace App\Policies;

use App\Models\Relations\UserTranslation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserTranslationPolicy
{
    use HandlesAuthorization;

    final public function viewAny(User $user): bool
    {
        return false;
    }

    final public function view(User $user, UserTranslation $userTranslation): bool
    {
        return $userTranslation->user()->is($user);
    }

    final public function create(User $user): bool
    {
        return true;
    }

    final public function update(User $user, UserTranslation $userTranslation): bool
    {
        return $userTranslation->user()->is($user);
    }

    final public function delete(User $user, UserTranslation $userTranslation): bool
    {
        return $userTranslation->user()->is($user);
    }

    final public function restore(User $user, UserTranslation $userTranslation): bool
    {
        return false;
    }

    final public function forceDelete(User $user, UserTranslation $userTranslation): bool
    {
        return false;
    }
}
