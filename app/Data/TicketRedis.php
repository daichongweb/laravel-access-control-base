<?php

namespace App\Data;

use Illuminate\Support\Facades\Redis;

/**
 * 微信jsapi_ticket存储
 */
class TicketRedis
{
    private static function key($memberId)
    {
        return 'token:wechat_member:' . $memberId;
    }

    public static function set(int $memberId, string $ticket, $expiresIn = 7200)
    {
        return Redis::setex(self::key($memberId), $expiresIn, $ticket);
    }

    public static function get($memberId)
    {
        return Redis::get(self::key($memberId));
    }
}
