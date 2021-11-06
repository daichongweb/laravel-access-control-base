<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * 微信登录控制器
 */
class LoginController extends Controller
{
    private $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';

    public function index(Request $request)
    {
        return redirect(sprintf($this->url, 'wx1fd8bd85dba2a4ef', 'http://qunmishu.tebaobao.vip/wechat-notify', 'uzrLd7PotGmgUUJpX5GBBUbrkCeueX8z'));
    }

    public function wechatNotify(Request $request)
    {
        var_dump($request->all());
    }
}
