<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\ChatGroupInfosModel;
use App\Models\ChatGroupMembersModel;
use App\Models\WechatMemberViewLogsModel;
use Illuminate\Http\JsonResponse;

/**
 * 首页控制器
 */
class HomeController extends Controller
{
    /**
     * 首页统计数据
     * @return JsonResponse
     */
    public function count(): JsonResponse
    {
        $joinNumber = WechatMemberViewLogsModel::query()->count();
        $memberNumber = ChatGroupMembersModel::query()->count();
        $chatGroupNumber = ChatGroupInfosModel::query()->count();
        return ResponseHelper::success(['join_number' => $joinNumber + $memberNumber, 'group_number' => $chatGroupNumber]);
    }
}
