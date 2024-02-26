<?php

namespace App\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

interface AuthServiceContract
{
    public function store(RegisterRequest $request): User;

    public function login(LoginRequest $request): JsonResponse|string;
}
