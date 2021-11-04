<?php

namespace App\Http\Controllers\Manager;

use App\Exceptions\ApiException;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\UploadsModel;
use App\Services\AlinOss;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * 文件上传控制器
 */
class UploadController extends Controller
{
    /**
     * 上传图片
     * @throws ApiException
     */
    public function image(Request $request): JsonResponse
    {
        $file = $request->file('image');
        $suffix = $file->getClientOriginalExtension() ?: 'png';
        $path = date('Ymd') . '/' . date('YmdHis') . '_' . Str::random(4) . '.' . $suffix;
        $ossService = new AlinOss();
        $ossService->uploadImage($path, $file);
        UploadsModel::query()->create([
            'enterprise_id' => $request->user()->enterprise_id,
            'member_id' => $request->user()->id,
            'file_path' => $path,
            'suffix' => $suffix,
            'service' => 'aliyun',
            'type' => 'image'
        ]);
        return ResponseHelper::success(['path' => $path]);
    }
}
