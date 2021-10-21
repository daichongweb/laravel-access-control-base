<?php

namespace App\Data;

use Illuminate\Support\Facades\Redis;

/**
 * 企业token存储
 */
class EnterpriseRedis
{
    private static function key()
    {
        return 'enterprise_access_token';
    }

    public static function set($token, $expiresIn)
    {
        return Redis::setex(self::key(), $expiresIn, $token);
    }

    public static function get()
    {
        return Redis::get(self::key());
    }
}
