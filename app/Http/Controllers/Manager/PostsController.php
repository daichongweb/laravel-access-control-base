<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostsRequest;
use App\Models\PostsModel;
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
        $request->offsetSet('content', strip_tags($request->get('content', '<p><img>')));
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
        $list = PostsModel::query()->with('tags')->with('covers')
            ->where('member_id', $request->user()->id)
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
        $info = PostsModel::query()->with('tags')
            ->with(['member' => function ($query) {
                $query->select(['id', 'username', 'avatar']);
            }])
            ->where('id', $request->get('id'))
            ->first();
        return ResponseHelper::success($info);
    }

    /**
     * 推荐列表
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $list = PostsModel::query()->with('tags')
            ->with('covers')
            ->with(['member' => function ($query) {
                $query->select(['id', 'username', 'avatar']);
            }])->orderBy('collect_num', 'desc')
            ->orderBy('share_num', 'desc')
            ->simplePaginate(15);
        return ResponseHelper::success($list);
    }
}
