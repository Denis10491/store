<?php

namespace App\Http\Controllers\Api\Product;

use App\Contracts\ProductServiceContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductStatisticsMonthlyBestSellingRequest;
use Illuminate\Http\JsonResponse;

class ProductStatisticsController extends Controller
{
    public function monthlyBestSelling(
        ProductStatisticsMonthlyBestSellingRequest $request,
        ProductServiceContract $service
    ): JsonResponse {
        return response()->json($service->monthlyBestSelling($request));
    }
}
