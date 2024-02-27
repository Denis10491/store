<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersStatisticsMonthlyAmountByDayRequest;
use Illuminate\Http\JsonResponse;

class OrderStatisticsController extends Controller
{
    public function monthlyAmountByDay(
        OrdersStatisticsMonthlyAmountByDayRequest $request,
        OrderServiceContract $service
    ): JsonResponse {
        return response()->json($service->monthlyAmountByDay($request));
    }
}
