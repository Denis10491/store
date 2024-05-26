<?php

namespace App\Contracts;

use App\Http\Requests\User\StoreRoleRequest;
use App\Http\Requests\User\UpdateRoleRequest;
use App\Models\Role;

interface RoleServiceContract
{
    public function create(StoreRoleRequest $request): Role;

    public function update(UpdateRoleRequest $request): Role;

    public function setRole(Role $role): static;
}