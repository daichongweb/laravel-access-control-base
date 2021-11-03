<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Models\TagsModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 *标签控制器
 */
class TagController extends Controller
{
    /**
     * 添加标签
     * @throws ApiException
     */
    public function create(TagRequest $request): JsonResponse
    {
        $request->offsetSet('member_id', $request->user()->id);
        $request->validate();
        $model = TagsModel::query()->create($request->all());
        if (!$model) {
            throw new ApiException('新增标签失败');
        }
        return ResponseHelper::success(['name' => $model->name, 'id' => $model->id]);
    }

    /**
     * 标签列表
     * @param Request $request
     * @return JsonResponse
     */
    public function list(Request $request): JsonResponse
    {
        $tags = TagsModel::query()->where('member_id', $request->user()->id)->get();
        return ResponseHelper::success($tags);
    }

    /**
     * 删除标签
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $bool = TagsModel::query()->where('id', $request->get('id'))->delete();
        return ResponseHelper::auto($bool);
    }
}
