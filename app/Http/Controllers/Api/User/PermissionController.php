<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\PermissionServiceContract;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StorePermissionRequest;
use App\Http\Requests\User\UpdatePermissionRequest;
use App\Http\Resources\User\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function store(StorePermissionRequest $request, PermissionServiceContract $service): JsonResponse
    {
        $createdPermission = $service->create($request);
        return response()->json(new PermissionResource($createdPermission), 201);
    }

    public function update(UpdatePermissionRequest $request, PermissionServiceContract $service, Permission $permission): JsonResponse
    {
        $updatedRole = $service->setPermission($permission)->update($request);
        return response()->json(new PermissionResource($updatedRole));
    }

    public function destroy(Permission $permission): JsonResponse
    {
        if (Gate::denies('delete-permission')) {
            throw new ForbiddenException();
        }

        $permission->delete();
        return responseOk();
    }
}
