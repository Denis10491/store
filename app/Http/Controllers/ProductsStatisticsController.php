<?php

namespace App\Http\Controllers;

use App\Contracts\ProductsServiceContract;
use App\Http\Requests\ProductsStatisticsMonthlyBestSellingRequest;
use Illuminate\Http\Response;

class ProductsStatisticsController extends Controller
{
    public function monthlyBestSelling(ProductsStatisticsMonthlyBestSellingRequest $request, ProductsServiceContract $service): Response
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