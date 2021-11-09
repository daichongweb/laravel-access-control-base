<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 微信相关控制器
 */
class WechatController extends Controller
{
    public function config(Request $request)
    {
        return ($request->user()->with('token')->first());
    }
}
