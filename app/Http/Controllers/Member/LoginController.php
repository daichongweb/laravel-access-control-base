<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\EnterpriseModel;
use App\Services\WechatAuthService;
use Illuminate\Http\Request;

/**
 * 微信登录控制器
 */
class LoginController extends Controller
{
    private $authUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect';


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
        return redirect(sprintf($this->authUrl, $enterprise->app_id, 'http://qunmishu.tebaobao.vip/wechat-notify', $enterprise->key));
    }

    /**
     * code换取access_token
     * @throws ApiException
     */
    public function wechatNotify(Request $request)
    {
        $code = $request->get('code');
        $state = $request->get('state');
        if (!$code || !$state) {
            throw new ApiException('授权失败');
        }
        $enterprise = EnterpriseModel::query()->where('key', $state)->first();
        if (!$enterprise) {
            throw new ApiException('企业不存在');
        }
        $wechatService = new WechatAuthService();
        $tokenData = $wechatService->getAccessToken($enterprise, $code);
        var_dump($tokenData);
    }
}
