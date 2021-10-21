<?php

namespace App\Http\Controllers\Api;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\CustomerGroupService;
use Illuminate\Http\JsonResponse;

/**
 * 客户群相关接口
 */
class CustomerGroupController extends Controller
{

    private $service;

    public function __construct(CustomerGroupService $customerGroupService)
    {
        $this->service = $customerGroupService;
        $this->service->token = EnterpriseRedis::get();
    }

    /**
     * 群列表
     * @throws ApiException
     */
    public function list(): JsonResponse
    {
        return ResponseHelper::success($this->service->groupList());
    }
}
