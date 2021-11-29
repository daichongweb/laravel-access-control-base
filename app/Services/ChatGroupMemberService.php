<?php

namespace App\Services;

use App\Models\ChatGroupMembersModel;

class ChatGroupMemberService
{
    public function getMemberById($id)
    {
        return ChatGroupMembersModel::query()->where('id', $id)->first();
    }

    public function getMemberByInfoIdAndUserId($info, $userId)
    {
        return ChatGroupMembersModel::query()
            ->where('info_id', $info)
            ->where('user_id', $userId)
            ->first();
    }
}
