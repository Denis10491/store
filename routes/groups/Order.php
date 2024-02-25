<?php


use App\Http\Controllers\Api\Order\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class)->middleware(['auth:sanctum'])->only('index', 'store');

Route::get('orders/statistics/monthlyamountbyday')->middleware([
    'auth:sanctum', 'role:admin'
])->name('orders.statistics.monthlyamountbyday');
