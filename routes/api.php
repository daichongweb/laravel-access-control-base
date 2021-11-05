<?php

use App\Http\Controllers\Manager\CustomerController;
use App\Http\Controllers\Manager\CustomerGroupController;
use App\Http\Controllers\Manager\EnterpriseController;
use App\Http\Controllers\Manager\LoginController;
use App\Http\Controllers\Manager\MemberController;
use App\Http\Controllers\Manager\PostsController;
use App\Http\Controllers\Manager\TagController;
use App\Http\Controllers\Manager\UploadController;
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

    // 企业相关
    Route::prefix('enterprise')->group(function () {
        Route::get('/get-token', [EnterpriseController::class, 'token'])->middleware('enterprise.key.valid');
        Route::post('/create', [EnterpriseController::class, 'create']);
        Route::get('/list', [EnterpriseController::class, 'list']);
        Route::post('/select', [EnterpriseController::class, 'select'])->middleware('enterprise.key.valid');
    });

    Route::middleware('enterprise.key.valid')->group(function () {
        //客户群相关
        Route::prefix('customer-group')->group(function () {
            Route::get('/list', [CustomerGroupController::class, 'list']);
            Route::get('/info', [CustomerGroupController::class, 'info']);
            Route::get('/sync-info', [CustomerGroupController::class, 'syncInfo']);
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

        // 上传图片
        Route::post('/upload/image', [UploadController::class, 'image']);

        // 素材相关
        Route::prefix('posts')->group(function () {
            Route::post('/create', [PostsController::class, 'create']);
            Route::get('/my', [PostsController::class, 'my']);
        });
    });

    // 素材标签
    Route::prefix('tag')->group(function () {
        Route::post('/create', [TagController::class, 'create']);
        Route::get('/list', [TagController::class, 'list']);
        Route::delete('/delete', [TagController::class, 'delete']);
    });
});

// 超级管理员登录
Route::post('/admin-login', [LoginController::class, 'adminLogin']);

// 企业管理员登录
Route::post('/member-login', [LoginController::class, 'memberLogin']);
