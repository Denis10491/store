<?php

use Illuminate\Support\Facades\Route;

Route::view('/admin', 'admin')->where('any', '.*');
Route::view('/admin/{any}', 'admin')->where('any', '.*');

Route::view('/login', 'index')->name('login');
Route::view('/{any}', 'index')->where('any', '.*');
