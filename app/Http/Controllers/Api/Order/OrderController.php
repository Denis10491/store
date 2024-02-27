<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\Order\OrderResource;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{
    public function index(OrderServiceContract $service): JsonResponse
    {
        $orders = $service->index();
        return response()->json(OrderResource::collection($orders));
    }

    public function store(StoreOrderRequest $request, OrderServiceContract $service): JsonResponse
    {
        $createdOrder = $service->store($request);
        return response()->json(new OrderResource($createdOrder), 201);
    }
}
