<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\LoginController;
use App\Http\Controllers\Member\PostsController;
use App\Http\Controllers\Member\WechatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth:sanctum')->group(function () {

    Route::middleware(['enterprise.key.valid', 'wechat.members'])->group(function () {
        // 素材相关
        Route::prefix('posts')->group(function () {
            Route::get('/info', [PostsController::class, 'info']);
        });

        // 公众号配置
        Route::prefix('wechat')->group(function () {
            Route::get('/config', [WechatController::class, 'config']);
        });
    });
});

Route::get('/get-user-info', [LoginController::class, 'getUserInfo']);
