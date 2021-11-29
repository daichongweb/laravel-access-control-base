<?php

namespace App\Services;

use App\Models\ChatGroupsModel;

class ChatGroupService
{
    public function getGroupById($id)
    {
        return ChatGroupsModel::query()->where('id', $id)->first();
    }
}
