<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Jobs\GroupChatJob;
use App\Services\CustomerGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 客户群相关接口
 */
class CustomerGroupController extends Controller
{

    private $service;

    public function __construct(CustomerGroupService $customerGroupService, Request $request)
    {
        $this->service = $customerGroupService;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
    }

    /**
     * 群列表
     * @throws ApiException
     */
    public function list(Request $request): JsonResponse
    {
        $corpUserId = $request->user()->corp_user_id;
        if (!$corpUserId) {
            throw new ApiException('请先绑定企业微信');
        }
        $groupChatList = $this->service->groupList($corpUserId, $request->get('limit', 10), $request->get('cursor'));
        if ($groupChatList) {
            foreach ($groupChatList['group_chat_list'] as &$chat) {
                $chatInfo = $this->service->groupInfo($chat['chat_id'], 0);
                $chat['name'] = $chatInfo['group_chat']['name'] ?: '未命名';
            }
        }
        return ResponseHelper::success($groupChatList);
    }

    /**
     * 群详情
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function info(Request $request): JsonResponse
    {
        $info = $this->service->groupInfo($request->get('chat_id'));
        GroupChatJob::dispatch($request->user(), $info);
        return ResponseHelper::success($info);
    }
}
