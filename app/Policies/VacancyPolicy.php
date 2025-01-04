<?php

namespace App\Policies;

use App\Enums\Role;
use App\Models\Vacancy;
use App\Models\User;

class VacancyPolicy {
    /**
     * Only authors and admins can create vacancies
     */
    public function create(User $user): bool
    {
        return $user->role == Role::AUTHOR || $user->role == Role::ADMIN;
    }

    /**
     * Only authors and admins can edit / update vacancies
     */
    public function edit(User $user): bool
    {
        return $user->role == Role::AUTHOR || $user->role == Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the vacancy.
     */
    public function delete(User $user): bool
    {
        return $user->role == Role::AUTHOR || $user->role == Role::ADMIN;
    }

    public function view(User $user): bool
    {
        return $user->role != Role::GUEST;
    }
}
