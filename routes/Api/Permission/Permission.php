<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Permission\PermissionController;


Route::apiResource('permissions', PermissionController::class)->middleware('auth:sanctum','is_admin');

