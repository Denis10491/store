<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\AuthServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthServiceContract $service): JsonResponse
    {
        $createdUser = $service->store($request);
        return response()->json(new UserResource($createdUser), 201);
    }

    public function login(LoginRequest $request, AuthServiceContract $service): JsonResponse
    {
        $token = $service->login($request);
        return response()->json(['token' => $token]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return responseOk();
    }
}
