<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Models\TextEntityGuesting;

class TextEntityGuestingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, TextEntityGuesting $textEntityGuesting): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, TextEntityGuesting $textEntityGuesting): bool
    {
        return false;
    }

    public function delete(User $user, TextEntityGuesting $textEntityGuesting): bool
    {
        return false;
    }

    public function restore(User $user, TextEntityGuesting $textEntityGuesting): bool
    {
        return false;
    }

    public function forceDelete(User $user, TextEntityGuesting $textEntityGuesting): bool
    {
        return false;
    }
}
