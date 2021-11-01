<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\EnterpriseModel;
use App\Models\MemberModel;
use App\Models\User;
use Illuminate\Http\JsonResponse;

/**
 * 登录相关控制器
 */
class LoginController extends Controller
{
    /**
     * 手机号&邮箱登录
     * @throws ApiException
     */
    public function adminLogin(LoginRequest $request): JsonResponse
    {
        $type = $request->post('type', 'nameLogin');
        $request->validate($type);
        $user = User::query();
        if ($type == 'nameLogin') {
            $user->where('name', $request->post('name'));
        } elseif ($type == 'emailLogin') {
            $user->where('email', $request->post('email'));
        }
        $loginUser = $user->first();
        if (!$loginUser) {
            throw new ApiException('账号或密码错误');
        }
        // 加密方式bcrypt($pwd)
        if (!password_verify($request->post('password'), $loginUser->password)) {
            throw new ApiException('账号或密码错误');
        }
        $token = $loginUser->createToken('admin');
        return ResponseHelper::success($token->plainTextToken);
    }

    /**
     * 企业成员登录
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function memberLogin(LoginRequest $request): JsonResponse
    {
        $type = $request->post('type', 'nameLogin');
        $request->validate($type);
        $user = MemberModel::query();
        if ($type == 'nameLogin') {
            $user->where('name', $request->post('name'));
        } elseif ($type == 'emailLogin') {
            $user->where('email', $request->post('email'));
        }
        $loginUser = $user->first();
        if (!$loginUser) {
            throw new ApiException('账号或密码错误');
        }
        // 加密方式bcrypt($pwd)
        if (!password_verify($request->post('password'), $loginUser->password)) {
            throw new ApiException('账号或密码错误');
        }
        $token = $loginUser->createToken('member');
        $enterprise = EnterpriseModel::query()->where('id', $loginUser->enterprise_id)->first();
        if (!$enterprise) {
            throw new ApiException('未绑定企业');
        }
        return ResponseHelper::success(['token' => $token->plainTextToken, 'key' => $enterprise->key]);
    }
}
