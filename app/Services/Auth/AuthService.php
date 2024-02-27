<?php

namespace App\Services\Auth;

use App\Contracts\AuthServiceContract;
use App\Enums\UserRole;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthService implements AuthServiceContract
{
    public function store(RegisterRequest $request): User
    {
        $data = $request->validated();
        $data['role'] = UserRole::User;
        return User::query()->create($data);
    }

    public function login(LoginRequest $request): JsonResponse|string
    {
        if (!auth()->guard()->attempt($request->validated())) {
            return response()->json(['message' => 'Incorrect data'], 401);
        }
        return auth()->user()->createToken('api_token')->plainTextToken;
    }
}
