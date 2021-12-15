<?php

namespace App\Http\Controllers\Member;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 角色控制器
 */
class RoleController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $model = Role::query()->create(['name' => $request->post('role_name')]);
        return ResponseHelper::auto($model);
    }

    public function del(Request $request): JsonResponse
    {
        $role = Role::query()->find($request->post('id'));
        return ResponseHelper::auto($role->delete());
    }
}
