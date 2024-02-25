<?php

namespace App\Services\Auth;

use App\Contracts\AuthServiceContract;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

class AuthService implements AuthServiceContract
{
    public function store(RegisterRequest $request): User
    {
        return User::create($request->validated());
    }

    public function login(LoginRequest $request): string
    {
        if (!auth()->guard()->attempt($request->validated())) {
            return response()->json(['message' => 'Incorrect data'], 401);
        }
        return auth()->user()->createToken('api_token')->plainTextToken;
    }
}
