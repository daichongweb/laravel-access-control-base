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
//rule中间内所有的路由都要加上name格式为{prefix:method}
Route::middleware(['auth:sanctum', 'rule'])->group(function () {

    Route::post('/login/out', [LoginController::class, 'out'])->name('login:out');

    // 角色管理
    Route::prefix('role')->group(function () {
        Route::post('/create', [RoleController::class, 'create'])->name('role:create');
        Route::put('/edit', [RoleController::class, 'edit'])->name('role:edit');
        Route::post('/disable', [RoleController::class, 'disable'])->name('role:disable');
        Route::post('/enable', [RoleController::class, 'enable'])->name('role:enable');
        Route::post('/bind-rule', [RoleController::class, 'bindRule'])->name('role:bind-rule');
        Route::post('/remove-rule', [RoleController::class, 'removeRule'])->name('role:remove-rule');
        Route::get('/index', [RoleController::class, 'index'])->name('role:index');
        Route::get('/rules', [RoleController::class, 'rules'])->name('role:rules');
    });

    // 权限管理
    Route::prefix('rule')->group(function () {
        Route::post('/create', [RuleController::class, 'create'])->name('rule:create');
        Route::put('/edit', [RuleController::class, 'edit'])->name('rule:edit');
        Route::post('/disable', [RuleController::class, 'disable'])->name('rule:disable');
        Route::post('/enable', [RuleController::class, 'enable'])->name('rule:enable');
        Route::get('/index', [RuleController::class, 'index'])->name('rule:index');
    });

    // 用户管理
    Route::prefix('user')->group(function () {
        Route::post('/bind-role', [UserController::class, 'bindRole'])->name('user:bind-role');
        Route::get('/info', [UserController::class, 'info'])->name('user:info');
        Route::put('/edit-pwd', [UserController::class, 'editPwd'])->name('user:edit-pwd');
        Route::get('/roles', [UserController::class, 'roles'])->name('user:roles');
        Route::get('/rules', [UserController::class, 'rules'])->name('user:rules');
    });
});

Route::post('/login', [LoginController::class, 'index']);
