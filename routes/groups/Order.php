<?php


use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Order\OrderStatisticsController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class)->middleware(['auth:sanctum'])->only('index', 'store');
Route::apiResource('orders', OrderController::class)->middleware(['auth:sanctum', 'role.admin'])->only('update');

Route::controller(OrderStatisticsController::class)
    ->middleware(['auth:sanctum', 'role.admin'])
    ->prefix('orders/statistics')
    ->as('orders.statistics.')
    ->group(function () {
        Route::get('monthlyamountbyday', 'monthlyAmountByDay')->name('monthlyamountbyday');
    });
