<?php

namespace App\Data;

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

    public static function get($key)
    {
        return Redis::get(self::key($key));
    }
}
