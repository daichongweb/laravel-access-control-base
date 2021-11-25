<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Models\PostsMiddleTagsModel;
use App\Services\ChatGroupMemberService;
use App\Services\WechatMembersService;
use Illuminate\Http\Request;

/**
 * 微信用户控制器
 */
class WechatMemberController extends Controller
{
    /**
     * @throws ApiException
     */
    public function tags(Request $request)
    {
        $groupMemberId = $request->get('group_member_id');
        if (!$groupMemberId) {
            throw new ApiException('请选择群成员');
        }
        $chatGroupMemberService = new ChatGroupMemberService();
        $chatGroupMember = $chatGroupMemberService->getMemberById($groupMemberId);
        if (!$chatGroupMember || !$chatGroupMember->unionid) {
            throw new ApiException('不是一个普通微信用户');
        }

        $wechatMemberService = new WechatMembersService();
        $wechatMember = $wechatMemberService->getMemberByUnionId($chatGroupMember->unionid, $chatGroupMember->enterprise_id);
        if (!$wechatMember) {
            throw new ApiException('该用户没有浏览素材记录');
        }
        $postIds = $wechatMemberService->getViewPosts($wechatMember->id);
        if (!$postIds) {
            throw new ApiException('该用户没有浏览素材记录');
        }
        return PostsMiddleTagsModel::query()
            ->whereIn('post_id', $postIds)
            ->get();
    }
}
