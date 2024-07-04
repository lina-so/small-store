<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Products\ProductController;
use App\Http\Controllers\Api\Category\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


$api_path = '/Api';
Route::prefix('api')->group(function() use ($api_path){

    include __DIR__ . "{$api_path}/Category/category.php";
    include __DIR__ . "{$api_path}/Products/product.php";
    include __DIR__ . "{$api_path}/Auth/auth.php";
    include __DIR__ . "{$api_path}/Order/order.php";
    include __DIR__ . "{$api_path}/User/user.php";
    include __DIR__ . "{$api_path}/Permission/Permission.php";



});
