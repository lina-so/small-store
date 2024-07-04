<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Products\ProductController;

Route::apiResource('products', ProductController::class)->middleware('auth:sanctum','is_admin');

