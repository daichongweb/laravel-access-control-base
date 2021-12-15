<?php

namespace App\Http\Controllers\Member;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 角色控制器
 */
class RoleController extends Controller
{
    private $service;

    public function __construct(RoleService $roleService)
    {
        $this->service = $roleService;
    }

    /**
     * @throws ApiException
     */
    public function create(RoleRequest $request): JsonResponse
    {
        $request->validate('create');
        $bool = Role::query()->create(['name' => $request->post('role_name')]);
        return ResponseHelper::auto($bool);
    }

    public function disable(Request $request): JsonResponse
    {
        return ResponseHelper::auto($this->service->disable($request->post('ids', [])));
    }

    public function enable(Request $request): JsonResponse
    {
        return ResponseHelper::auto($this->service->enable($request->post('ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function bindRule(RoleRequest $request): JsonResponse
    {
        $request->validate('change');
        return ResponseHelper::auto($this->service->addRule($request->post('role_id'), $request->post('rule_ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function removeRule(RoleRequest $request): JsonResponse
    {
        $request->validate('change');
        return ResponseHelper::auto($this->service->delRule($request->post('role_id'), $request->post('rule_ids', [])));
    }
}
