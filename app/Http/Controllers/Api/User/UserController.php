<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function show(): JsonResponse
    {
        Log::info(Auth::user()->email.' received his data');
        return response()->json(new UserResource(Auth::user()));
    }
}
