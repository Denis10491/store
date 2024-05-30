<?php

namespace App\Http\Controllers\Api\User;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePermissionRoleRequest;
use App\Http\Resources\User\RoleResource;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class PermissionRoleController extends Controller
{
    public function store(StorePermissionRoleRequest $request, Role $role): JsonResponse
    {
        $permission = Permission::find($request->input('permission_id'));

        $role->permissions()->attach($permission->id);

        return response()->json(new RoleResource($role));
    }

    public function destroy(Role $role, Permission $permission): JsonResponse
    {
        if (Gate::denies('delete-permission-role')) {
            throw new ForbiddenException();
        }

        $role->permissions()->detach($permission->id);
        return responseOk();
    }
}
