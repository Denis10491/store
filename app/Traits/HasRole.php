<?php

namespace App\Traits;

use App\Enums\UserRole;

trait HasRole
{
    public function isAdmin(): bool
    {
        return $this->role === UserRole::Admin;
    }

    public function isUser(): bool
    {
        return $this->role === UserRole::User;
    }
}
