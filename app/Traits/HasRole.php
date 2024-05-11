<?php

namespace App\Traits;

use App\Enums\Role;
use App\Enums\UserRole;

trait HasRole
{
    public function isAdmin(): bool
    {
        return Role::tryFrom($this->role->name) === Role::Admin;
    }

    public function isUser(): bool
    {
        return Role::tryFrom($this->role->name) === Role::User;
    }
}
