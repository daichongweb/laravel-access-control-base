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
    /**
     * code换取access_token
     * @throws ApiException
     */
    public function getUserInfo(Request $request): JsonResponse
    {
        $code = $request->get('code');
        $key = $request->get('key');
        if (!$code || !$key) {
            throw new ApiException('授权失败');
        }
        $enterprise = EnterpriseModel::query()->where('key', $key)->first();
        if (!$enterprise) {
            throw new ApiException('企业不存在');
        }
        DB::beginTransaction();
        try {
            $wechatService = new WechatAuthService();
            $tokenData = $wechatService->getAccessToken($enterprise, $code);
            // 存储授权记录
            $tokenData['enterprise_id'] = $enterprise->id;
            $tokenData['unionid'] = $tokenData['unionid'] ?? '';
            $tokenData['expires_in'] = (int)$tokenData['expires_in'];
            $tokenModel = WechatAccessTokensModel::query()->updateOrCreate([
                'enterprise_id' => $enterprise->id,
                'openid' => $tokenData['openid']
            ], $tokenData);

            // 存储微信用户信息
            $userInfo = $wechatService->getUserInfo($tokenData['access_token'], $tokenData['openid']);
            $userInfo['enterprise_id'] = $enterprise->id;
            $userInfo['unionid'] = $userInfo['unionid'] ?? '';
            $memberModel = WechatMembers::query()->updateOrCreate([
                'enterprise_id' => $enterprise->id,
                'openid' => $tokenData['openid']
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
