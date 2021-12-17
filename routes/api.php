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
        Route::put('/edit', [RoleController::class, 'edit']);
        Route::post('/disable', [RoleController::class, 'disable']);
        Route::post('/enable', [RoleController::class, 'enable']);
        Route::post('/bind-rule', [RoleController::class, 'bindRule']);
        Route::post('/remove-rule', [RoleController::class, 'removeRule']);
        Route::get('/index', [RoleController::class, 'index']);
        Route::get('/rules', [RoleController::class, 'rules']);
    });

    // 权限管理
    Route::prefix('rule')->group(function () {
        Route::post('/create', [RuleController::class, 'create']);
        Route::put('/edit', [RuleController::class, 'edit']);
        Route::post('/disable', [RuleController::class, 'disable']);
        Route::post('/enable', [RuleController::class, 'enable']);
        Route::get('/index', [RuleController::class, 'index']);
    });

    // 用户管理
    Route::prefix('user')->group(function () {
        Route::post('/bind-role', [UserController::class, 'bindRole']);
        Route::get('/info', [UserController::class, 'info']);
        Route::put('/edit-pwd', [UserController::class, 'editPwd']);
    });
});

Route::post('/login', [LoginController::class, 'index']);
