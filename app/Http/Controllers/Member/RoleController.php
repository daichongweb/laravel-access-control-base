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

    /**
     * @throws ApiException
     */
    public function edit(RoleRequest $request): JsonResponse
    {
        $request->validate('create');
        $role = $this->service->findById($request->post('role_id'));
        if (!$role) {
            throw new ApiException('角色不存在');
        }
        $role->name = $request->get('role_name');
        return ResponseHelper::auto($role->save());
    }

    /**
     * @throws ApiException
     */
    public function disable(RoleRequest $request): JsonResponse
    {
        $request->validate('change-status');
        return ResponseHelper::auto($this->service->disable($request->post('role_ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function enable(RoleRequest $request): JsonResponse
    {
        $request->validate('change-status');
        return ResponseHelper::auto($this->service->enable($request->post('role_ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function bindRule(RoleRequest $request): JsonResponse
    {
        $request->validate('change-rule');
        return ResponseHelper::auto($this->service->addRule($request->post('role_id'), $request->post('rule_ids', [])));
    }

    /**
     * @throws ApiException
     */
    public function removeRule(RoleRequest $request): JsonResponse
    {
        $request->validate('change-rule');
        return ResponseHelper::auto($this->service->delRule($request->post('role_id'), $request->post('rule_ids', [])));
    }
}
