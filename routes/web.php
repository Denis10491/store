<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::view('/admin', 'admin')->where('any', '.*');
Route::view('/admin/{any}', 'admin')->where('any', '.*');
Route::view('/login', 'index')->name('login');
Route::view('/{any}', 'index')->where('any', '.*');