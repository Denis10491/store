<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{    
    
    public function register(Request $request) {
        $credentials = $request->validated();
        $user = User::create($credentials);
        $user->assignRole('user');
        return response(['status' => true, 'data' => $user]);
    }

    public function login(Request $request) {
        $credentials = $request->validated();

        if (Auth::guard()->attempt($credentials)) {
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
