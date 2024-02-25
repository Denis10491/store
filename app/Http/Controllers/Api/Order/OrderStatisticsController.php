<?php

namespace App\Http\Controllers\Api\Order;

use App\Contracts\OrderServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrdersStatisticsMonthlyAmountByDayRequest;
use Illuminate\Http\Response;

class OrderStatisticsController extends Controller
{
    public function monthlyAmountByDay(
        OrdersStatisticsMonthlyAmountByDayRequest $request,
        OrderServiceContract $service
    ): Response
    {
        $credentials = $request->validated();
        return response([
            'status' => true,
            'data' => $service->monthlyAmountByDay($credentials['year'], $credentials['month']),
            'year' => $credentials['year'],
            'month' => $credentials['month']
        ]);
    }
}
