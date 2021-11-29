<?php

namespace App\Services;

use App\Models\ChatGroupMembersModel;

class ChatGroupMemberService
{
    public function getMemberById($id)
    {
        return ChatGroupMembersModel::query()->where('id', $id)->first();
    }

    public function getMemberByGroupIdAndUserId($groupId, $userId)
    {
        return ChatGroupMembersModel::query()
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->first();
    }
}
