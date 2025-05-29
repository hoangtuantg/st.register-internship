<?php

namespace App\Policies;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermission('topic.index');
    }


    /**
     * Quyền tạo mới
     */
    public function create(User $user): bool
    {
        return $user->hasPermission('topic.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Topic $topic): bool
    {
        return $user->hasPermission('topic.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Topic $topic): bool
    {
        return $user->hasPermission('topic.delete');
    }

}
