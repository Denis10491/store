<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->prefix('auth.')->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'login')->name('login');
    Route::get('/logout', 'logout')->middleware(['auth:sanctum'])->name('logout');
});
