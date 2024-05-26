<?php

namespace App\Services\User;

use App\Contracts\RoleServiceContract;
use App\Http\Requests\User\StoreRoleRequest;
use App\Http\Requests\User\UpdateRoleRequest;
use App\Models\Role;

class RoleService implements RoleServiceContract
{
    protected Role $role;

    public function create(StoreRoleRequest $request): Role
    {
        return Role::query()->create($request->validated());
    }

    public function update(UpdateRoleRequest $request): Role
    {
        return $this->role->fill($request->validated());
    }

    public function setRole(Role $role): static
    {
        $this->role = $role;

        return $this;
    }
}