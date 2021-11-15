<?php

namespace App\Http\Controllers\Member;

use App\Data\AccessTokenRedis;
use App\Data\TicketRedis;
use App\Exceptions\ApiException;
use App\Exceptions\LoginException;
use App\Helpers\ResponseHelper;
use App\Helpers\WechatHelper;
use App\Http\Controllers\Controller;
use App\Models\EnterpriseModel;
use App\Services\TicketService;
use App\Services\WechatAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * 微信相关控制器
 */
class WechatController extends Controller
{
    /**
     * @throws LoginException|ApiException
     */
    public function config(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $ticket = TicketRedis::get($currentUser->id);
        if (!$ticket) {
            $accessToken = AccessTokenRedis::get($request->user()->enterprise_id);
            $ticketService = new TicketService();
            $result = $ticketService->get($accessToken['access_token']);
            if ($result['errcode'] != 0) {
                throw new ApiException($result['errmsg']);
            }
            $ticket = $result['ticket'];
            TicketRedis::set($currentUser->id, $ticket, $result['expires_in']);
        }
        $parameter = [
            'noncestr' => Str::random(),
            'jsapi_ticket' => $ticket,
            'timestamp' => time(),
            'url' => $request->get('url')
        ];
        $parameter['signature'] = WechatHelper::ticketSign($parameter);
        return ResponseHelper::success($parameter);
    }

    /**
     * 刷新用户access-token
     * @throws ApiException|LoginException
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $enterprise = EnterpriseModel::query()->where('key', $request->header('key'))->first();
        if (!$enterprise) {
            throw new ApiException('企业不存在');
        }

        $wechatService = new WechatAuthService();
        $tokenData = $wechatService->refreshToken($enterprise, $request->user()->token['refresh_token']);
        if (isset($tokenData['errcode'])) {
            throw new LoginException('请重新登录');
        }
        $tokenModel = $wechatService->insertToken($enterprise->id, $tokenData);
        if (!$tokenModel) {
            throw new ApiException('刷新失败');
        }
        return ResponseHelper::success();
    }
}
