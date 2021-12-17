<?php

namespace App\Http\Controllers\Member;

use App\Enums\CommonStatus;
use App\Exceptions\ApiException;
use App\Helpers\ArrayHelper;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RuleRequest;
use App\Models\Rule;
use App\Services\RuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 规则管理
 */
class RuleController extends Controller
{
    /**
     * @throws ApiException
     */
    public function create(RuleRequest $request): JsonResponse
    {
        $request->validate('create');
        return ResponseHelper::auto(Rule::query()->create($request->all()));
    }

    /**
     * @throws ApiException
     */
    public function edit(RuleRequest $request): JsonResponse
    {
        $request->validate('edit');
        $bool = Rule::query()->where('id', $request->get('id'))->update($request->only([
            'name',
            'route',
            'parent_id'
        ]));
        return ResponseHelper::auto($bool);
    }

    /**
     * @throws ApiException
     */
    public function disable(RuleRequest $request): JsonResponse
    {
        $request->validate('change-status');
        $ruleService = new RuleService();
        return ResponseHelper::auto($ruleService->disable($request->post('rule_ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function enable(RuleRequest $request): JsonResponse
    {
        $request->validate('change-status');
        $ruleService = new RuleService();
        return ResponseHelper::auto($ruleService->enable($request->post('rule_ids', [])));
    }

    public function index(Request $request): JsonResponse
    {
        $model = Rule::query();
        $status = $request->get('status', -1);
        if ($status != -1 && in_array($status, CommonStatus::map())) {
            $model->where('status', $status);
        }
        $parentId = $request->get('parent_id', -1);
        $isGroup = $request->get('is_group', 0);
        if ($parentId != -1) {
            $model->where('parent_id', $parentId);
        }
        $rules = $model->select(['id', 'name', 'status', 'parent_id'])->get();
        if ($isGroup && $parentId == -1) {
            $rules = ArrayHelper::getTree($rules->toArray());
        }
        return ResponseHelper::success($rules);
    }
}
