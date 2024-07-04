<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Category\CategoryController;

Route::apiResource('categories', CategoryController::class)->middleware('auth:sanctum','is_admin');

