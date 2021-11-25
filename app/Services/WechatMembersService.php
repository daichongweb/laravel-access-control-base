<?php

namespace App\Services;

use App\Models\WechatMembers;
use App\Models\WechatMemberViewLogsModel;
use Illuminate\Support\Collection;

/**
 * 微信用户服务
 */
class WechatMembersService
{
    public function getMemberByUnionId($unionId, $enterpriseId)
    {
        return WechatMembers::query()
            ->where('unionid', $unionId)
            ->where('enterprise_id', $enterpriseId)
            ->first();
    }

    public function getViewPosts($memberId): Collection
    {
        return WechatMemberViewLogsModel::query()->where('wechat_member_id', $memberId)->pluck('post_id');
    }
}
