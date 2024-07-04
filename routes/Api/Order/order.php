<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Api\Auth\AuthController;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function(){

        Route::middleware('auth:sanctum','is_admin')
        ->group(function(){
            Route::apiResource('orders', OrderController::class);

        });

    });
