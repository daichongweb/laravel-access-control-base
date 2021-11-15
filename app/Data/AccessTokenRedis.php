<?php

namespace App\Data;

use App\Exceptions\ApiException;
use App\Models\EnterpriseModel;
use App\Services\TicketService;
use Illuminate\Support\Facades\Redis;

/**
 * 公众号access_token
 */
class AccessTokenRedis
{
    private static function key(int $enterpriseId): string
    {
        return 'enterprise:wechat:access_token:' . $enterpriseId;
    }

    /**
     * @throws ApiException
     */
    public static function get(int $enterpriseId)
    {
        $token = Redis::get(self::key($enterpriseId));
        if ($token) {
            $ticketService = new TicketService();
            $result = $ticketService->accessToken(EnterpriseModel::query()->find($enterpriseId));
            $token = $result['access_token'];
            self::set($enterpriseId, $token, $result['expires_in']);
        }
        return $token;
    }

    public static function set(int $enterpriseId, string $accessToken, $expiresIn = 7200)
    {
        return Redis::setex(self::key($enterpriseId), $expiresIn, $accessToken);
    }
}
