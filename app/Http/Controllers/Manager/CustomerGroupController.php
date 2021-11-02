<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\CustomerGroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 客户群相关接口
 */
class CustomerGroupController extends Controller
{

    private $service;

    public function __construct(CustomerGroupService $customerGroupService, Request $request)
    {
        $this->service = $customerGroupService;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
    }

    /**
     * 群列表
     * @throws ApiException
     */
    public function list(Request $request): JsonResponse
    {
        return ResponseHelper::success($this->service->groupList($request->get('member_id'), $request->get('limit', 10), $request->get('cursor')));
    }

    /**
     * 群详情
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function info(Request $request): JsonResponse
    {
        return ResponseHelper::success($this->service->groupInfo($request->get('chat_id')));
    }
}
