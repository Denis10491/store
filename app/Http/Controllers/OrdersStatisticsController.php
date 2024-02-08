<?php

namespace App\Http\Controllers;

use App\Contracts\OrdersServiceContract;
use App\Http\Requests\OrdersStatisticsMonthlyAmountByDayRequest;
use Illuminate\Http\Response;

class OrdersStatisticsController extends Controller
{
    public function monthlyAmountByDay(OrdersStatisticsMonthlyAmountByDayRequest $request, OrdersServiceContract $service): Response
    {
        $credentials = $request->validated();
        $data = $service->monthlyAmountByDay($credentials['year'], $credentials['month']);
        return response([
            'status' => true,
            'year' => $credentials['year'],
            'month' => $credentials['month'],
            'data' => $data
        ]);
    }
}
