<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Payment\PaymentController;

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


Route::controller(PaymentController::class)
    ->group(function(){
        Route::middleware('auth')
        ->group(function(){
            Route::get('/', 'index');
            Route::get('/handle','handle')->name('handle');
            Route::get('/success','success')->name('success');
        });

    });
