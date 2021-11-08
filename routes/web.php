<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\LoginController;
use App\Http\Controllers\Member\PostsController;
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

Route::middleware('enterprise.key.valid')->group(function () {
    // 微信授权登录获取用户信息
    Route::get('/get-user-info', [LoginController::class, 'getUserInfo']);
    Route::middleware('auth:sanctum')->group(function () {
        // 素材
        Route::prefix('posts')->group(function () {
            Route::get('/info', [PostsController::class, 'info']);
        });
    });

});
