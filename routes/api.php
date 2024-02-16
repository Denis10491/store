<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\OrdersStatisticsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProductsStatisticsController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/* Guest */
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/products/page/{page}', [ProductsController::class, 'index'])->name('products.index.paginated');
Route::get('/products/{id}', [ProductsController::class, 'show'])->name('products.show');

/* Auth */
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user', [UserController::class, 'show'])->name('user.show');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/orders', [OrdersController::class, 'store'])->name('orders.store');
    Route::get('/orders/page/{page}', [OrdersController::class, 'index'])->name('orders.index.paginated');
});
 
/* Admin */
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
    Route::put('/products/{id}', [ProductsController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

    /* Statistics */
    Route::group(['prefix' => 'statistics'], function() {
        Route::get('/orders/monthlyamountbyday', [OrdersStatisticsController::class, 'monthlyAmountByDay'])->name('statistics.orders.monthlyamountbyday');
        Route::get('/products/monthlybestselling', [ProductsStatisticsController::class, 'monthlyBestSelling'])->name('statistics.products.monthlybestselling');
    });
});