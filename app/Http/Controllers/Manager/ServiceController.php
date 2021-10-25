<?php

namespace App\Http\Controllers\Manager;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\ProviderService;
use Illuminate\Http\JsonResponse;

/**
 * 服务商相关业务控制器
 */
class ServiceController extends Controller
{
    /**
     * @throws ApiException
     */
    public function index(): JsonResponse
    {
        $token = EnterpriseRedis::get();
        if (!$token) {
            $providerService = new ProviderService();
            $tokenData = $providerService->getProviderToken();
            $token = $tokenData['provider_access_token'];
            $expiresIn = $tokenData['expires_in'];
            EnterpriseRedis::set($token, $expiresIn);
        }
        return ResponseHelper::success($token);
    }
}
