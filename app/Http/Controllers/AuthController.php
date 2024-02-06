<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{    
    
    public function register(RegisterRequest $request): Response {
        $user = User::create($request->validated());
        return response(['status' => true, 'data' => $user]);
    }

    public function login(LoginRequest $request): Response {
        if (Auth::guard()->attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return response([
                'status' => true,
                'token' => $token
            ], 200);
        }
        abort(401);
    }
    
    public function logout(Request $request): Response {
        Auth::user()->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response('', 201);
    }
}
