<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthService $service): JsonResponse
    {
        $createdUser = $service->store($request);
        return response()->json(new UserResource($createdUser), 201);
    }

    public function login(LoginRequest $request, AuthService $service): JsonResponse
    {
        return response()->json($service->login($request));
    }

    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();
        return response()->json(['message' => 'Success']);
    }
}
