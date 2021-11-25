<?php

namespace App\Services;

use App\Models\ChatGroupMembersModel;

class ChatGroupMemberService
{
    public function getMemberById($id)
    {
        return ChatGroupMembersModel::query()->where('id', $id)->first();
    }
}
