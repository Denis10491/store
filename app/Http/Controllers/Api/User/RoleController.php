<?php

namespace App\Http\Controllers\Api\User;

use App\Contracts\RoleServiceContract;
use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreRoleRequest;
use App\Http\Requests\User\UpdateRoleRequest;
use App\Http\Resources\User\RoleResource;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(RoleResource::collection(Role::query()->get()));
    }

    public function show(Role $role): JsonResponse
    {
        return response()->json(new RoleResource($role));
    }

    public function store(StoreRoleRequest $request, RoleServiceContract $service): JsonResponse
    {
        $createdRole = $service->create($request);
        return response()->json(new RoleResource($createdRole), 201);
    }

    public function update(UpdateRoleRequest $request, RoleServiceContract $service, Role $role): JsonResponse
    {
        $updatedRole = $service->setRole($role)->update($request);
        return response()->json(new RoleResource($updatedRole));
    }

    public function destroy(Role $role): JsonResponse
    {
        if (Gate::denies('delete-role')) {
            throw new ForbiddenException();
        }

        $role->delete();
        return responseOk();
    }
}
