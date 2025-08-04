<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function approver(User $user): bool
    {
        return $user->role_id == Role::IS_APPROVER || $user->role_id == Role::IS_ADMIN;
    }

    public function encoder(User $user): bool
    {
        return $user->role_id == Role::IS_ENCODER || $user->role_id == Role::IS_ADMIN;
    }

    public function sales(User $user): bool
    {
        return $user->role_id == Role::IS_SALES || $user->role_id == Role::IS_ADMIN; 
    }

    public function admin(User $user): bool
    {
        return $user->role_id == Role::IS_ADMIN || $user->role_id == Role::IS_ADMIN;
    }
}
