<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function show() {
        return response([
            'status' => Auth::check(), 
            'data' => new UserResource(Auth::user()),
        ]);
    }
}
