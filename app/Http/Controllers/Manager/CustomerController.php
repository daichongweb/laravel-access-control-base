<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\WechatMemberViewTagsModel;
use App\Services\ChatGroupMemberService;
use App\Services\CustomerService;
use App\Services\WechatMembersService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 客户相关接口
 */
class CustomerController extends Controller
{

    private $service;

    /**
     * @throws ApiException
     */
    public function __construct(CustomerService $customerService, Request $request)
    {
        $this->service = $customerService;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
    }

    /**
     * 获取客户详情
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getUserInfo(Request $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $groupId = $request->get('group_id');
        $groupMemberService = new ChatGroupMemberService();
        $groupMember = $groupMemberService->getMemberByGroupIdAndUserId($groupId, $userId);
        if (!$groupMember->unionid) {
            throw new ApiException('该用户不是一个外部成员');
        }
        $memberService = new WechatMembersService();
        $viewTags = [];
        if ($member = $memberService->getMemberByUnionId($groupMember->unionid, $groupMember->enterprise_id)) {
            // 用户浏览过的标签
            $viewTags = WechatMemberViewTagsModel::query()
                ->with('tag', function ($query) {
                    $query->orderBy('view_num', 'desc');
                })
                ->where('wechat_member_id', $member->id)
                ->select(['view_num', 'tag_id'])
                ->get();
        }
        return ResponseHelper::success(['wechat_member' => $member, 'tags' => $viewTags]);
    }
}
