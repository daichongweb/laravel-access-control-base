<?php

namespace App\Http\Controllers\Member;

use App\Events\WechatMemberViewEvent;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostViewRequest;
use App\Models\PostsModel;
use App\Models\WechatMemberViewLogsModel;
use Illuminate\Http\JsonResponse;

/**
 * 文章控制器
 */
class PostsController extends Controller
{
    /**
     * 文章详情
     * @param PostViewRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function info(PostViewRequest $request): JsonResponse
    {
        $enterprise_id = $request->user()->enterprise_id;
        $userId = $request->user()->id;
        $request->offsetSet('enterprise_id', $enterprise_id);
        $request->offsetSet('wechat_member_id', $userId);
        $request->validate();
        $info = PostsModel::query()
            ->with('tags')
            ->with(['member' => function ($query) {
                $query->select(['id', 'username', 'avatar']);
            }])
            ->where('id', $request->get('id'))
            ->first();
        if (!$info) {
            throw new ApiException('素材不存在');
        }
        WechatMemberViewEvent::dispatch($request->user(), $info, $request->all());
        return ResponseHelper::success($info);
    }
}
