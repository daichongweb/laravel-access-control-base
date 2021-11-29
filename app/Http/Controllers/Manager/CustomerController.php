<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\WechatMemberViewTagsModel;
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
        $memberInfo = $this->service->info($userId);
        if ($memberInfo['errcode'] > 0) {
            throw new ApiException('该用户不是一个外部成员.1');
        }
        $externalContact = $memberInfo['external_contact'] ?? '';
        if (!$externalContact) {
            throw new ApiException('该用户不是一个外部成员.2');
        }
        $memberService = new WechatMembersService();
        $viewTags = [];
        if ($member = $memberService->getMemberByUnionId($externalContact['unionid'], $request->user()->enterprise_id)) {
            // 用户浏览过的标签
            $viewTags = WechatMemberViewTagsModel::query()
                ->with('tag')
                ->where('wechat_member_id', $member->id)
                ->select(['view_num', 'tag_id'])
                ->get();
        }
        return ResponseHelper::success(['wechat_member' => $member, 'chat_group_member' => $externalContact, 'tags' => $viewTags]);
    }
}
