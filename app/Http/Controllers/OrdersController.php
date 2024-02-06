<?php

namespace App\Http\Controllers;

use App\Contracts\OrdersServiceContract;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrdersServiceContract $service, string $page): Response
    {
        if (!$user = Auth::user()) abort(401, 'Unathorizated');
        return response([
            'status' => true,
            'user_id' => $user->id,
            'data' => $service->getPage($user, $page)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request, OrdersServiceContract $service): Response
    {
        return response([
            'status' => $service->create(Auth::user(), $request->validated()) ? true : false
        ]);
    }
}
