<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\CustomerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 客户相关接口
 */
class CustomerController extends Controller
{

    private $service;

    public function __construct(CustomerService $customerService, Request $request)
    {
        $this->service = $customerService;
        $this->service->token = EnterpriseRedis::get($request->header('key'));
    }

    /**
     * 获取客户详情
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function getUserInfo(Request $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $cursor = $request->get('cursor');
        return ResponseHelper::success($this->service->info($userId, $cursor));
    }
}
