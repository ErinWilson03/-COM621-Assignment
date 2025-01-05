<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\User;

class ApplicationPolicy
{
    /**
     * Only a user can apply for a vacancy
     */
    public function apply(User $user): bool
    {
        return $user->role == Role::USER;
    }
    /**
     * Only a user and admin can edit applications
     */
    public function edit(User $user): bool
    {
        return $user->role == Role::USER || $user->role == Role::ADMIN;
    }

    /**
     * Everyone but guests can view applications
     */
    public function view(User $user): bool
    {
        return $user->role != Role::GUEST;
    }

    /**
     * Only a user and admin can delete applications
     */
    public function delete(User $user): bool
    {
        return $user->role == Role::ADMIN || $user->role == Role::USER;
    }
}
