<?php

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

Route::prefix('group')->group(function () {
    Route::get('/list', [CustomerGroupController::class, 'list']);
});
