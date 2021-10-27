<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\MemberModel;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;

/**
 * 企业服务人员管理
 */
class MemberController extends Controller
{
    public $service;

    public function __construct(MemberService $memberServices)
    {
        $this->service = $memberServices;
        $this->service->token = EnterpriseRedis::get();
    }

    /**
     * 获取配置了客户联系功能的成员列表
     * @throws ApiException
     */
    public function list(): JsonResponse
    {
        return ResponseHelper::success(['access_token' => $this->service->followUserList()]);
    }

    /**
     * 新增企业成员
     * @param MemberRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function create(MemberRequest $request): JsonResponse
    {
        $request->validate('create');
        $currentUser = $request->user();
        $pid = $currentUser->id;
        if ($currentUser->type == User::ADMIN) {
            $pid = 0;
        }
        $model = MemberModel::query()->create(array_merge($request->all(), ['pid' => $pid, 'password' => bcrypt($request->post('password'))]));
        if (!$model) {
            throw new ApiException('新增企业成员失败');
        }
        return ResponseHelper::success();
    }
}
