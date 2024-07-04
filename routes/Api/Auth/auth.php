<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;

Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function(){

        Route::middleware('guest:sanctum')
        ->group(function(){
            Route::post('/login','login')->name('login');
            Route::post('/register','signUp')->name('register');
        });

    });
