<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(OrderServiceContract $service, string $page): Response
    {
        $user = Auth::user();
        if (!$user) abort(401, 'Unathorizated');
        return response([
            'status' => true,
            'user_id' => $user->id,
            'data' => $service->getPage($user, $page)
        ]);
    }

    public function store(StoreOrderRequest $request, OrderServiceContract $service): Response
    {
        return response([
            'status' => $service->create(Auth::user(), $request->validated()) ? true : false
        ]);
    }
}
