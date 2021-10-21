<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\EnterpriseService;
use Illuminate\Http\JsonResponse;

/**
 * 企业相关接口控制器
 */
class EnterpriseController extends Controller
{
    /**
     * @throws ApiException
     */
    public function token(): JsonResponse
    {
        $service = new EnterpriseService();
        return ResponseHelper::success(['access_token' => $service->getToken()]);
    }
}
