<?php

namespace App\Http\Controllers\Member;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 规则管理
 */
class RuleController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $rule = Rule::query()->create([
            'name' => $request->post('name'),
            'route' => $request->post('route'),
            'parent_id' => $request->post('parent_id', 0)
        ]);
        return ResponseHelper::auto($rule);
    }
}
