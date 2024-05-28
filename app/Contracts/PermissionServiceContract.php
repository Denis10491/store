<?php

namespace App\Contracts;

use App\Http\Requests\User\StorePermissionRequest;
use App\Http\Requests\User\UpdatePermissionRequest;
use App\Models\Permission;

interface PermissionServiceContract
{
    public function create(StorePermissionRequest $request): Permission;

    public function update(UpdatePermissionRequest $request): Permission;

    public function setPermission(Permission $permission): static;
}