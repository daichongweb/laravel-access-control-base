<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Models\PostsModel;
use App\Models\WechatMemberViewLogsModel;
use App\Services\PostsService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * 素材控制器
 */
class PostsController extends Controller
{
    /**
     * 创建素材
     * @param PostsRequest $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function create(PostsRequest $request): JsonResponse
    {
        $request->offsetSet('enterprise_id', $request->user()->enterprise_id);
        $request->offsetSet('member_id', $request->user()->id);
        $request->offsetSet('content', strip_tags($request->get('content'), '<p><img>'));
        $request->validate();
        DB::beginTransaction();
        try {
            $posts = PostsModel::query()->create($request->all());
            $posts->tags()->sync($request->get('tags'));
            $posts->covers()->sync($request->get('covers'));
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new ApiException($exception->getMessage());
        }
        return ResponseHelper::success();
    }

    /**
     * 个人素材列表
     * @param Request $request
     * @return JsonResponse
     */
    public function my(Request $request): JsonResponse
    {
        $tagId = $request->get('tag_id', 0);
        $query = PostsModel::query();
        if ($tagId) {
            $query->whereHas('tags', function (Builder $builder) use ($tagId) {
                return $builder->where('tag_id', $tagId);
            });
        }
        $list = $query->withCount('viewMembers')
            ->with('tags')
            ->with('covers')
            ->where('member_id', $request->user()->id)
            ->orderBy('is_top', 'desc')
            ->orderBy('created_at', 'desc')
            ->simplePaginate(15);
        return ResponseHelper::success($list);
    }

    /**
     * 文章详情
     * @param Request $request
     * @return JsonResponse
     */
    public function info(Request $request): JsonResponse
    {
        $memberId = $request->user()->id;
        $info = PostsModel::query()
            ->withExists(['collect' => function ($query) use ($memberId) {
                $query->where('member_id', $memberId);
            }])
            ->with(['tags', 'covers'])
            ->with(['member' => function ($query) {
                $query->select(['id', 'username', 'avatar']);
            }])
            ->where('id', $request->get('id'))
            ->first();
        return ResponseHelper::success($info);
    }

    /**
     * 推荐列表
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $list = PostsModel::query()
            ->withCount('viewMembers')
            ->with('tags')
            ->with('covers')
            ->with(['member' => function ($query) {
                $query->select(['id', 'username', 'avatar']);
            }])
            ->where('enterprise_id', $request->user()->enterprise_id)
            ->where('is_public', PostsModel::PUBLIC)
            ->orderBy('collect_num', 'desc')
            ->orderBy('share_num', 'desc')
            ->simplePaginate(15);
        return ResponseHelper::success($list);
    }

    /**
     * 文章浏览日志
     * @param Request $request
     * @return JsonResponse
     */
    public function viewLog(Request $request): JsonResponse
    {
        $list = WechatMemberViewLogsModel::query()
            ->with('wechatMembers', function ($query) {
                $query->select(['id', 'nickname', 'headimgurl', 'updated_at']);
            })
            ->where('post_id', $request->get('post_id'))
            ->select(['wechat_member_id', 'view_num'])
            ->simplePaginate(15);
        return ResponseHelper::success($list);
    }

    /**
     * 文章置顶
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function top(Request $request): JsonResponse
    {
        $postService = new PostsService();
        $post = $postService->getByMemberId($request->get('post_id'), $request->user()->id);
        if (!$post) {
            throw new ApiException('文章不存在');
        }
        if ($post->is_top) {
            throw new ApiException('已经置顶了');
        }
        // 取消置顶
        if ($topPost = $postService->getTopByMemberId($request->user()->id)) {
            $topPost->is_top = 0;
            $topPost->save();
        }
        $post->is_top = PostsModel::TOP;
        if (!$post->save()) {
            throw new ApiException('置顶失败');
        }
        return ResponseHelper::success();
    }

    /**
     * 删除文章
     * @throws ApiException
     */
    public function delete(Request $request): JsonResponse
    {
        $posts = (new PostsService())->getByMemberId($request->get('post_id'), $request->user()->id);
        if (!$posts) {
            throw new ApiException('文章不存在');
        }
        return ResponseHelper::auto($posts->delete());
    }
}
