<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Mail\Admin\OrderNotifyMail;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($request->user())->queue(new OrderNotifyMail($request->user(), $createdOrder));
        return response()->json(new OrderResource($createdOrder), 201);
    }

    public function update(Order $order, UpdateOrderRequest $request, OrderServiceContract $service): JsonResponse
    {
        $updatedOrder = $service->update($order, $request);
        return response()->json(new OrderResource($updatedOrder));
    }
}
