<?php

use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\ProductStatisticsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::controller(ProductStatisticsController::class)
    ->middleware(['auth:sanctum', 'role:admin'])
    ->prefix('products/statistics')
    ->as('products.statistics.')
    ->group(function () {
        Route::get('monthlybestselling', 'monthlyBestSelling')->name('monthlybestselling');
    });
