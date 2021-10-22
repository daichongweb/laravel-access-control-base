<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\CustomerGroupController;
use App\Http\Controllers\Api\EnterpriseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/get_token', [EnterpriseController::class, 'token']);

//客户群相关
Route::prefix('customer-group')->group(function () {
    Route::get('/list', [CustomerGroupController::class, 'list']);
    Route::get('/info', [CustomerGroupController::class, 'info']);
});

// 客户相关
Route::prefix('customer')->group(function () {
    Route::get('/info', [CustomerController::class, 'getUserInfo']);
});
