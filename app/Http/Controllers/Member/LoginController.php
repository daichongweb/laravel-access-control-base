<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\EnterpriseModel;
use Illuminate\Http\Request;

/**
 * 微信登录控制器
 */
class LoginController extends Controller
{
    private $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=123#wechat_redirect';

    private $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';

    /**
     * 微信授权
     * @throws ApiException
     */
    public function index(Request $request)
    {
        $key = $request->get('key');
        if (!$key) {
            throw new ApiException('企业标识错误');
        }
        $enterprise = EnterpriseModel::query()->where('key', $key)->first();
        if (!$enterprise) {
            throw new ApiException('企业不存在');
        }
        return redirect(sprintf($this->authUrl, $enterprise->app_id, env('APP_URL') . '/wechat-notify'));
    }

    /**
     * code换取access_token
     * @throws ApiException
     */
    public function wechatNotify(Request $request)
    {
        $code = $request->get('code');
        if (!$code) {
            throw new ApiException('授权失败');
        }
        var_dump($request->all());
    }
}
