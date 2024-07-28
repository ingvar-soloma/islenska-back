<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;

class TopicPolicy
{
    final public function viewAny(User $user): bool
    {
        return true;
    }

    final public function view(User $user, Topic $topic): bool
    {
        return true;
    }

    final public function create(User $user): bool
    {
        return false;
    }

    final public function update(User $user, Topic $topic): bool
    {
        return false;
    }

    final public function delete(User $user, Topic $topic): bool
    {
        return false;
    }

    final public function restore(User $user, Topic $topic): bool
    {
        return false;
    }

    final public function forceDelete(User $user, Topic $topic): bool
    {
        return false;
    }
}
