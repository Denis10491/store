<?php

namespace App\Contracts;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;

interface AuthServiceContract
{
    public function store(RegisterRequest $request): User;

    public function login(LoginRequest $request): string;
}
