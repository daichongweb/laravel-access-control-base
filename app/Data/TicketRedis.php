<?php

namespace App\Data;

use App\Exceptions\ApiException;
use App\Services\TicketService;
use Illuminate\Support\Facades\Redis;

/**
 * 微信jsapi_ticket存储
 */
class TicketRedis
{
    private static function key($enterpriseId)
    {
        return 'token:wechat_member:' . $enterpriseId;
    }

    public static function set(int $enterpriseId, string $ticket, $expiresIn = 7200)
    {
        return Redis::setex(self::key($enterpriseId), $expiresIn, $ticket);
    }

    /**
     * @throws ApiException
     */
    public static function get($enterpriseId)
    {
        $token = Redis::get(self::key($enterpriseId));
        if (!$token) {
            $ticketService = new TicketService();
            $result = $ticketService->get(AccessTokenRedis::get($enterpriseId));
            $token = $result['ticket'];
            self::set($enterpriseId, $token, $result['expires_in']);
        }
        return $token;
    }
}
