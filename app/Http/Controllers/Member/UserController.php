<?php

namespace App\Http\Controllers\Member;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
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
}
