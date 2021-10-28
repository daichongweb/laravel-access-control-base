<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Enums\AuthEnum;
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
        if (!$request->user()->tokenCan(AuthEnum::MEMBER_CREATE)) {
            throw new ApiException('无权限操作');
        }
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

    /**
     * 绑定企业微信user_id
     * @throws ApiException
     */
    public function bind(MemberRequest $request): JsonResponse
    {
        $request->validate('bind');
        $member = MemberModel::query()
            ->where('name', $request->post('name'))
            ->where('enterprise_id', $request->post('enterprise_id'))
            ->first();
        if (!$member) {
            throw new ApiException('成员不存在');
        }
        $member->corp_user_id = $request->post('corp_user_id');
        if (!$member->save()) {
            throw new ApiException('绑定失败');
        }
        return ResponseHelper::success();
    }
}
