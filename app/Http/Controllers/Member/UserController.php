<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UserRequest;
use App\Models\RolesMiddleRules;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 用户控制器
 */
class UserController extends Controller
{
    /**
     * sync是同步覆盖，attach是新增
     * @param RoleRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function bindRole(RoleRequest $request): JsonResponse
    {
        $request->validate('user-bind-role');
        $bindType = $request->get('bind-type', 'sync');
        $roleIds = $request->post('role_ids');
        $bool = true;
        if ($bindType == 'attach') {
            $middle = (new RoleService())->getRoleIdsByUserId($request->user()->id);
            $roleIds = array_values(array_diff($roleIds, $middle->toArray()));
        }
        if ($roleIds) {
            $bool = $request->user()->roles()->$bindType($roleIds);
        }
        return ResponseHelper::auto($bool);
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
        if ($bool = $request->user()->save()) {
            $request->user()->tokens()->delete();
        }
        return ResponseHelper::auto($bool);
    }

    /**
     * @throws ApiException
     */
    public function roles(UserRequest $request): JsonResponse
    {
        $request->validate('role-rule');
        $user = User::query()->with('roles')->where('id', $request->get('user_id'))->first();
        return ResponseHelper::success($user);
    }

    /**
     * @throws ApiException
     */
    public function rules(UserRequest $request): JsonResponse
    {
        $request->validate('role-rule');
        $roleIds = (new RoleService())->getRoleIdsByUserId($request->get('user_id'));
        $rules = RolesMiddleRules::query()->with('rule', function ($query) {
            $query->select(['id', 'name', 'route', 'status', 'parent_id']);
        })->where('role_id', $roleIds)->get();
        return ResponseHelper::success($rules);
    }
}
