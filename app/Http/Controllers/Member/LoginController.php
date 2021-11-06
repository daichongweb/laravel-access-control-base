<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\EnterpriseModel;
use App\Models\WechatAccessTokensModel;
use App\Models\WechatMembers;
use App\Services\WechatAuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function wechatNotify(Request $request): JsonResponse
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
        DB::beginTransaction();
        try {
            $wechatService = new WechatAuthService();
            $tokenData = $wechatService->getAccessToken($enterprise, $code);

            // 存储授权记录
            $tokenData['open_id'] = $tokenData['openid'];
            $tokenData['enterprise_id'] = $enterprise->id;
            $tokenModel = WechatAccessTokensModel::query()->updateOrCreate([
                'enterprise_id' => $enterprise->id,
                'open_id' => $tokenData['access_token']
            ], $tokenData);
            $userInfo = $wechatService->getUserInfo($tokenData['access_token'], $tokenData['openid']);

            // 存储微信用户信息
            $userInfo['open_id'] = $tokenData['openid'];
            $userInfo['enterprise_id'] = $enterprise->id;
            $memberModel = WechatMembers::query()->updateOrCreate([
                'enterprise_id' => $enterprise->id,
                'open_id' => $tokenData['access_token']
            ], $userInfo);
            if (!$tokenModel || !$memberModel) {
                throw new ApiException('授权失败');
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ApiException($exception->getMessage());
        }
        return ResponseHelper::success($memberModel);
    }
}
