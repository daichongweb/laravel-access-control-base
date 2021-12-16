<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RuleRequest;
use App\Models\Rule;
use App\Services\RuleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

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
}
