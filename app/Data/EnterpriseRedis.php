<?php

namespace App\Data;

use App\Exceptions\ApiException;
use App\Models\EnterpriseModel;
use App\Services\EnterpriseService;
use Illuminate\Support\Facades\Redis;

/**
 * 企业token存储
 */
class EnterpriseRedis
{
    private static function key($key): string
    {
        return 'enterprise_access_token:' . $key;
    }

    public static function set($key, $token, $expiresIn)
    {
        return Redis::setex(self::key($key), $expiresIn, $token);
    }

    /**
     * @throws ApiException
     */
    public static function get($key)
    {
        $token = Redis::get(self::key($key));
        if (!$token) {
            $enterprise = EnterpriseModel::query()->where('key', $key)->first();
            return (new  EnterpriseService())->getToken($enterprise);
        }
        return $token;
    }
}
