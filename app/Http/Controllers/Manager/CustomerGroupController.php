<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Jobs\GroupChatJob;
use App\Jobs\SyncChatGroupListJob;
use App\Models\ChatGroupMembersModel;
use App\Models\ChatGroupsModel;
use App\Services\ChatGroupService;
use App\Services\CustomerGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

/**
 * 客户群相关接口
 */
class CustomerGroupController extends Controller
{

    private $service;

    /**
     * @throws ApiException
     */
    public function __construct(CustomerGroupService $customerGroupService, Request $request)
    {
        $this->service = $customerGroupService;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
    }

    /**
     * 群列表
     */
    public function list(Request $request): JsonResponse
    {
        $list = ChatGroupsModel::query()
            ->where('member_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);
        return ResponseHelper::success($list);
    }

    /**
     * 群详情
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request): JsonResponse
    {
        $list = ChatGroupMembersModel::query()->where('group_id', $request->get('group_id'))->simplePaginate(10);
        return ResponseHelper::success($list);
    }

    /**
     * 同步群详情
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function syncInfo(Request $request): JsonResponse
    {
        $groupId = $request->get('group_id');
        $chat = (new ChatGroupService())->getGroupById($groupId);
        if (!$chat) {
            throw new ApiException('客户群不存在');
        }
        $info = $this->service->groupInfo($chat->chat_id);
        GroupChatJob::dispatch($request->user(), $info, $groupId);
        return ResponseHelper::success();
    }

    /**
     * 同步群列表
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function syncList(Request $request): JsonResponse
    {
        $currentUser = $request->user();
        $corpUserId = $currentUser->corp_user_id;
        if (!$corpUserId) {
            throw new ApiException('请先绑定企业微信');
        }
        $executed = RateLimiter::attempt(
            'sync-chat-group-list:' . $currentUser->id,
            2,
            function () use ($currentUser) {
                SyncChatGroupListJob::dispatch($currentUser, $this->service->token);
            },
            86400
        );
        if (!$executed) {
            throw new ApiException('每二十四小时限制操作两次');
        }
        return ResponseHelper::success();
    }
}
