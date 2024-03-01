<?php

use App\Http\Controllers\Api\Product\ProductController;
use App\Http\Controllers\Api\Product\ProductStatisticsController;
use App\Http\Controllers\Api\Product\ReviewController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::apiResource('products.reviews', ReviewController::class)
    ->only('store', 'update', 'destroy')->shallow();

Route::controller(ProductStatisticsController::class)
    ->middleware(['auth:sanctum', 'role.admin'])
    ->prefix('products/statistics')
    ->as('products.statistics.')
    ->group(function () {
        Route::get('monthlybestselling', 'monthlyBestSelling')->name('monthlybestselling');
    });
