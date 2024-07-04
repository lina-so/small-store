<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;


Route::apiResource('users', UserController::class)->middleware('auth:sanctum','is_admin');

