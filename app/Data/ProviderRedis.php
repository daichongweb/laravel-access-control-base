<?php

namespace App\Data;

use Illuminate\Support\Facades\Redis;

/**
 * 服务商token存储
 */
class ProviderRedis
{
    private static function key()
    {
        return 'provider_access_token';
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
