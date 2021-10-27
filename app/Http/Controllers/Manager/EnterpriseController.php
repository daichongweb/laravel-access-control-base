<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\EnterpriseRequest;
use App\Models\EnterpriseModel;
use App\Services\EnterpriseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

/**
 * 企业相关接口控制器
 */
class EnterpriseController extends Controller
{
    /**
     * 获取企业微信access-token
     * @throws ApiException
     */
    public function token(): JsonResponse
    {
        $service = new EnterpriseService();
        return ResponseHelper::success(['access_token' => $service->getToken()]);
    }

    /**
     * 新增企业
     * @throws ApiException
     */
    public function create(EnterpriseRequest $enterpriseRequest): JsonResponse
    {
        $enterpriseRequest->validate();
        if (!$enterpriseRequest->user()->tokenCan('enterprise:create')) {
            throw new ApiException('无权限操作');
        }
        $model = EnterpriseModel::query()->create($enterpriseRequest->all());
        if (!$model) {
            throw new ApiException('新增失败');
        }
        return ResponseHelper::success(['key' => $model->key]);
    }
}
