<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 用户控制器
 */
class UserController extends Controller
{
    public function bindRole(Request $request): JsonResponse
    {
        $model = $request->user()->roles()->sync($request->post('role_ids'));
        return ResponseHelper::auto($model);
    }

    public function info(Request $request): JsonResponse
    {
        return ResponseHelper::success($request->user());
    }

    /**
     * @throws ApiException
     */
    public function editPwd(UserRequest $request): JsonResponse
    {
        $request->validate('edit_pwd');
        if (!password_verify($request->post('old_pwd'), $request->user()->password)) {
            throw new ApiException('旧密码错误');
        }
        $request->user()->password = bcrypt($request->post('new_pwd'));
        return ResponseHelper::auto($request->user()->save());
    }
}
