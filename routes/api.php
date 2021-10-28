<?php

use App\Http\Controllers\Manager\CustomerController;
use App\Http\Controllers\Manager\CustomerGroupController;
use App\Http\Controllers\Manager\EnterpriseController;
use App\Http\Controllers\Manager\LoginController;
use App\Http\Controllers\Manager\MemberController;
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
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('enterprise')->group(function () {
        Route::get('/get-token', [EnterpriseController::class, 'token']);
        Route::post('/create', [EnterpriseController::class, 'create']);
    });
    //客户群相关
    Route::prefix('customer-group')->group(function () {
        Route::get('/list', [CustomerGroupController::class, 'list']);
        Route::get('/info', [CustomerGroupController::class, 'info']);
    });

    // 客户相关
    Route::prefix('customer')->group(function () {
        Route::get('/info', [CustomerController::class, 'getUserInfo']);
    });

    // 企业成员相关
    Route::prefix('member')->group(function () {
        Route::get('/follow-list', [MemberController::class, 'list']);
        Route::post('/create', [MemberController::class, 'create']);
        Route::post('/bind', [MemberController::class, 'bind']);
    });
});

// 超级管理员登录
Route::post('/admin-login', [LoginController::class, 'adminLogin']);

// 企业管理员登录
Route::post('/member-login', [LoginController::class, 'memberLogin']);
