<?php

use App\Http\Controllers\Api\User\PermissionController;
use App\Http\Controllers\Api\User\PermissionRoleController;
use App\Http\Controllers\Api\User\RoleController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)->middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', 'show')->name('users.show');
});

Route::apiResource('roles', RoleController::class)->middleware(['auth:sanctum']);

Route::apiResource('permissions', PermissionController::class)
    ->middleware(['auth:sanctum'])
    ->only('store', 'update', 'destroy');

Route::apiResource('roles.permissions', PermissionRoleController::class)
    ->middleware(['auth:sanctum'])
    ->only('store', 'destroy');
