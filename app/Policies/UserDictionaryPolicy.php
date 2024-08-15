<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserDictionary;
use App\Traits\HasOwner;
use Illuminate\Auth\Access\Response;

class UserDictionaryPolicy
{
    use HasOwner;

    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, UserDictionary $userDictionary): bool
    {
        return $this->isOwner($user, $userDictionary);
    }

    final public function create(User $user): bool
    {
        return true;
    }

    final public function update(User $user, UserDictionary $userDictionary): bool
    {
        return $this->isOwner($user, $userDictionary);

    }

    final public function delete(User $user, UserDictionary $userDictionary): bool
    {
        return $this->isOwner($user, $userDictionary);
    }

    final public function restore(User $user, UserDictionary $userDictionary): bool
    {
        return false;
    }

    final public function forceDelete(User $user, UserDictionary $userDictionary): bool
    {
        return false;
    }
}
