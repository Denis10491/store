<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ProductsInOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function countOfOrdersByMonth(Request $request)
    {
        $credentials = $request->validate([
            'year' => ['required'],
            'month' => ['required']
        ]);
        $dateStart = $credentials["year"].'-'.$credentials["month"].'-01 00:00:00';
        $dateEnd = $credentials["year"].'-'.$credentials["month"].'-31 00:00:00';
        $data = [];

        $data = Order::whereBetween('created_at', [$dateStart, $dateEnd])
            ->orderBy('created_at')
            ->get()
            ->groupBy(function($data) {
                return Carbon::parse($data->created_at)->format('d');
            });

        return response([
            'status' => true,
            'year' => $credentials["year"],
            'month' => $credentials["month"],
            'data' => $data
        ]);
    }
}
