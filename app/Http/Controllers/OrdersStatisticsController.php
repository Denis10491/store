<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdersStatisticsCountByMonthPerDayRequest;
use App\Services\OrdersService;
use Illuminate\Http\Response;

class OrdersStatisticsController extends Controller
{
    public function monthlyAmountByDay(OrdersStatisticsCountByMonthPerDayRequest $request, OrdersService $service): Response
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
