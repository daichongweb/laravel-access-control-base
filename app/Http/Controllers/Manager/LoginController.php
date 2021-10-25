<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
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
    public function login(LoginRequest $request): JsonResponse
    {
        $type = $request->post('type', 'mobileLogin');
        $request->validate($type);
        $user = User::query();
        if ($type == 'mobileLogin') {
            $user->where('name', $request->post('mobile_phone'));
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
        $token = $loginUser->createToken('login');
        return ResponseHelper::success($token->plainTextToken);
    }
}
