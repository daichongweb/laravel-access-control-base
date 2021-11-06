<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Member\LoginController;
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

Route::get('/auth', [AuthController::class, 'authorizing']);


Route::get('/login', [LoginController::class, 'index']);
Route::get('/wechat-notify', [LoginController::class, 'wechatNotify']);
