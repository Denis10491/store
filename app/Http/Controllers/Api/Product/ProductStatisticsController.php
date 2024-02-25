<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsStatisticsMonthlyBestSellingRequest;
use Illuminate\Http\Response;

class ProductStatisticsController extends Controller
{
    public function monthlyBestSelling(
        ProductsStatisticsMonthlyBestSellingRequest $request,
        ProductServiceContract $service
    ): Response
    {
        $credentials = $request->validated();
        return response([
            'status' => true,
            'data' => $service->monthlyBestSelling($credentials['year'], $credentials['month']),
            'year' => $credentials['year'],
            'month' => $credentials['month']
        ]);
    }
}
