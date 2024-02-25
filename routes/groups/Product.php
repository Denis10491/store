<?php

use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResource('products', ProductController::class);

Route::get('/products/statistics/monthlybestselling', 'monthlyBestSelling')->middleware([
    'auth:sanctum', 'role:admin'
])->name('products.statistics.monthlybestselling');
