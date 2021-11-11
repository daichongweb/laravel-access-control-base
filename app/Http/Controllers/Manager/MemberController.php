<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Enums\AuthEnum;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\ModifyInfoRequest;
use App\Models\CollectsModel;
use App\Models\MemberModel;
use App\Models\PostsModel;
use App\Models\User;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 企业服务人员管理
 */
class MemberController extends Controller
{
    public $service;

    /**
     * @throws ApiException
     */
    public function __construct(MemberService $memberServices, Request $request)
    {
        $this->service = $memberServices;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
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

    /**
     * 修改用户信息
     * @throws ApiException
     */
    public function modifyInfo(ModifyInfoRequest $request): JsonResponse
    {
        $request->validate();
        $model = MemberModel::query()->updateOrCreate([
            'id' => $request->user()->id
        ], $request->all());
        if (!$model) {
            throw new ApiException('更新失败');
        }
        return ResponseHelper::success($model);
    }

    /**
     * 收藏素材
     * @throws ApiException
     */
    public function collect(Request $request): JsonResponse
    {
        $postId = $request->get('post_id');
        if (!PostsModel::query()->where('id', $postId)->exists()) {
            throw new ApiException('素材不存在');
        }
        $memberId = $request->user()->id;
        $value = [
            'post_id' => $postId,
            'member_id' => $memberId
        ];
        $model = CollectsModel::query()->updateOrCreate($value, $value);
        if (!$model) {
            throw new ApiException('收藏失败');
        }
        return ResponseHelper::success();
    }

    /**
     * 取消收藏
     * @throws ApiException
     */
    public function unCollect(Request $request): JsonResponse
    {
        $collectId = $request->get('collect_id');
        $model = CollectsModel::query()
            ->where('id', $collectId)
            ->where('member_id', $request->user()->id)
            ->first();
        if (!$model) {
            throw new ApiException('未找到收藏记录');
        }
        if (!$model->delete()) {
            throw new ApiException('取消收藏失败');
        }
        return ResponseHelper::success();
    }
}
