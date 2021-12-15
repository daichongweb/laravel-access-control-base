<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 微信登录控制器
 */
class LoginController extends Controller
{
    /**
     * @throws ApiException
     */
    public function index(LoginRequest $request): JsonResponse
    {
        $type = $request->post('type', 'name-login');
        $request->validate($type);
        $user = User::query();
        if ($type == 'name-login') {
            $user->where('name', $request->post('name'));
        } elseif ($type == 'email-login') {
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
        // 先撤销所有令牌
        $loginUser->tokens()->delete();
        $token = $loginUser->createToken('admin');
        return ResponseHelper::success($token->plainTextToken);
    }

    public function out(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        return ResponseHelper::success();
    }
}
