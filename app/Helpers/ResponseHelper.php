<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    public static function success($data = []): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'code' => 200,
            'status' => 'success',
            'timestamp' => time(),
            'message' => 'success'
        ]);
    }

    public static function error($message = 'error'): JsonResponse
    {
        return response()->json([
            'data' => [],
            'code' => 200,
            'status' => 'error',
            'timestamp' => time(),
            'message' => $message
        ]);
    }

    public static function auto($bool): JsonResponse
    {
        if ($bool) {
            return self::success();
        }
        return self::error();
    }
}
