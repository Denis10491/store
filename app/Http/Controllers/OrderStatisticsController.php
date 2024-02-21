<?php

namespace App\Http\Controllers;

use App\Contracts\OrdersServiceContract;
use App\Http\Requests\OrdersStatisticsMonthlyAmountByDayRequest;
use Illuminate\Http\Response;

class OrderStatisticsController extends Controller
{
    public function monthlyAmountByDay(OrdersStatisticsMonthlyAmountByDayRequest $request, OrdersServiceContract $service): Response
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
