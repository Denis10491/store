<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{    
    
    public function register(RegisterRequest $request) {
        $user = User::create($request->validated());
        $user->assignRole('user');
        return response(['status' => true, 'data' => $user]);
    }

    public function login(LoginRequest $request) {
        if (Auth::guard()->attempt($request->validated())) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response([
                "status" => true,
                "token" => $token
            ], 200);
        }
        return response(['status' => false], 401);
    }
    
    public function logout(Request $request) {
        Auth::user()->tokens()->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response(['status' => true], 200);
    }
}
