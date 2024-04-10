<?php

namespace App\Http\Controllers\Api\Auth;

use App\Contracts\AuthServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\User\UserResource;
use App\Mail\User\WelcomeMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request, AuthServiceContract $service): JsonResponse
    {
        $createdUser = $service->store($request);
        Mail::to($createdUser)->queue(new WelcomeMail());
        Log::info($createdUser->email.' created an account');
        return response()->json(new UserResource($createdUser), 201);
    }

    public function login(LoginRequest $request, AuthServiceContract $service): JsonResponse
    {
        $token = $service->login($request);
        Log::info($request->str('email').' is logged in');
        return response()->json(['token' => $token]);
    }

    public function logout(): JsonResponse
    {
        Log::info(Auth::user()->email.' has logged out');
        auth()->user()->tokens()->delete();
        return responseOk();
    }
}
