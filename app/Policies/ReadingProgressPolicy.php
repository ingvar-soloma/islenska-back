<?php

namespace App\Policies;

use App\Models\ReadingProgress;
use App\Models\User;
use App\Traits\HasOwner;

class ReadingProgressPolicy
{
    use HasOwner;

    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, ReadingProgress $readingProgress): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return true;
    }

    final public function update(User $user, ReadingProgress $readingProgress): bool
    {
        return $this->isOwner($user, $readingProgress);
    }

    final public function delete(User $user, ReadingProgress $readingProgress): bool
    {
        return false;
    }

    final public function restore(User $user, ReadingProgress $readingProgress): bool
    {
        return false;
    }

    final public function forceDelete(User $user, ReadingProgress $readingProgress): bool
    {
        return false;
    }
}
