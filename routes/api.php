<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
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
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register'])->name('register');
Route::get('/products/index', [ProductsController::class, 'index']);
Route::get('/products/show/{id}', [ProductsController::class, 'show']);

/* Auth */
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::get('/user/show', [UserController::class, 'show']);
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
    Route::post('/orders/store', [OrdersController::class, 'store']);
    Route::get('/orders/show', [OrdersController::class, 'show']);
});
 
/* Admin */
Route::group(['middleware' => ['auth:sanctum', 'role:admin']], function() {
    Route::get('/orders/index', [OrdersController::class, 'index']);
    Route::post('/products/store', [ProductsController::class, 'store']);
    Route::put('/products/update', [ProductsController::class, 'update']);
    Route::delete('/products/destroy/{id}', [ProductsController::class, 'destroy']);

    /* Statistics */
    Route::group(['prefix' => 'statistics'], function() {
        Route::get('/orders/count', [StatisticsController::class, 'countOfOrdersByMonth']);
        Route::get('/orders/bestselling', [StatisticsController::class, 'bestSellingByMonth']);
    });
});