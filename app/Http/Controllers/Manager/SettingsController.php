<?php

namespace App\Http\Controllers\Manager;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * 配置控制器
 */
class SettingsController extends Controller
{
    /**
     * 版本检测
     * @param Request $request
     * @return JsonResponse
     */
    public function version(Request $request): JsonResponse
    {
        $setting = (new SettingService())->getSettingByName('version');
        return ResponseHelper::success($request->get('version') < $setting->options['version'] ? $setting->options : []);
    }
}
