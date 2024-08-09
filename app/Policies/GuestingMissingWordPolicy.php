<?php

namespace App\Policies;

use App\Models\User;
use App\Models\GuestingMissingWord;
use Illuminate\Auth\Access\HandlesAuthorization;

class GuestingMissingWordPolicy
{
    use HandlesAuthorization;

    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, GuestingMissingWord $guestingMissingWord): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, GuestingMissingWord $guestingMissingWord): bool
    {
        return false;
    }

    final public function delete(User $user, GuestingMissingWord $guestingMissingWord): bool
    {
        return false;
    }

    final public function restore(User $user, GuestingMissingWord $guestingMissingWord): bool
    {
        return false;
    }

    final public function forceDelete(User $user, GuestingMissingWord $guestingMissingWord): bool
    {
        return false;
    }
}
