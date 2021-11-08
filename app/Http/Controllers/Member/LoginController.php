<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\EnterpriseModel;
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
        if (!$code) {
            throw new ApiException('授权失败');
        }
        $enterprise = EnterpriseModel::query()->where('key', $request->header('key'))->first();
        if (!$enterprise) {
            throw new ApiException('企业不存在');
        }
        DB::beginTransaction();
        try {
            $wechatService = new WechatAuthService();
            $tokenData = $wechatService->getAccessToken($enterprise, $code);
            if (isset($tokenData['errcode'])) {
                throw new ApiException($tokenData['errmsg']);
            }
            $tokenModel = $wechatService->insertToken($enterprise->id, $tokenData);
            $userInfo = $wechatService->getUserInfo($tokenData['access_token'], $tokenData['openid']);
            if (isset($userInfo['errcode'])) {
                throw new ApiException($userInfo['errmsg']);
            }
            $memberModel = $wechatService->insertUser($enterprise->id, $userInfo);
            if (!$tokenModel || !$memberModel) {
                throw new ApiException('授权失败');
            }
            $memberModel->tokens()->delete();
            $token = $memberModel->createToken('wechat-member', ['posts:info', 'posts:list']);
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            throw new ApiException($exception->getMessage());
        }
        return ResponseHelper::success(['token' => $token->plainTextToken, 'user' => $memberModel]);
    }
}
