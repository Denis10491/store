<?php

namespace App\Services\User;
use App\Contracts\PermissionServiceContract;
use App\Http\Requests\User\StorePermissionRequest;
use App\Http\Requests\User\UpdatePermissionRequest;
use App\Models\Permission;

class PermissionService implements PermissionServiceContract
{
    protected Permission $permission;

    public function create(StorePermissionRequest $request): Permission
    {
        return Permission::query()->create($request->validated());
    }

    public function update(UpdatePermissionRequest $request): Permission
    {
        return $this->permission->fill($request->validated());
    }

    public function setPermission(Permission $permission): static
    {
        $this->permission = $permission;

        return $this;
    }
}