<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LanguagePolicy
{
    use HandlesAuthorization;

    final public function viewAny(User $user): bool
    {
        return true;

    }

    final public function view(User $user, Language $language): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, Language $language): bool
    {
        return false;
    }

    final public function delete(User $user, Language $language): bool
    {
        return false;
    }

    final public function restore(User $user, Language $language): bool
    {
        return false;
    }

    final public function forceDelete(User $user, Language $language): bool
    {
        return false;
    }
}
