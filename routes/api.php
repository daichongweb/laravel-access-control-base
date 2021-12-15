<?php

use App\Http\Controllers\Member\LoginController;
use App\Http\Controllers\Member\RoleController;
use App\Http\Controllers\Member\RuleController;
use App\Http\Controllers\Member\UserController;
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
    Route::post('/login/out', [LoginController::class, 'out']);

    // 角色管理
    Route::prefix('role')->group(function () {
        Route::post('/create', [RoleController::class, 'create']);
        Route::post('/disable', [RoleController::class, 'disable']);
        Route::post('/enable', [RoleController::class, 'enable']);
        Route::post('/bind-rule', [RoleController::class, 'bindRule']);
    });

    // 权限管理
    Route::prefix('rule')->group(function () {
        Route::post('/create', [RuleController::class, 'create']);
    });

    // 用户管理
    Route::prefix('user')->group(function () {
        Route::post('/bind-role', [UserController::class, 'bindRole']);
    });
});

Route::post('/login', [LoginController::class, 'index']);
