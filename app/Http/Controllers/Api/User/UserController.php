<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show(): Response {
        return response([
            'status' => Auth::check(),
            'data' => new UserResource(Auth::user()),
        ]);
    }
}
