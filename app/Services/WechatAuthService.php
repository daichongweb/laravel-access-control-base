<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 微信授权服务
 */
class WechatAuthService
{
    private $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';

    /**
     * 获取微信用户access_token
     * @throws ApiException
     */
    public function getAccessToken($enterprise, $code)
    {
        $curl = new CurlService();
        $curl->setMethod('get');
        $curl->setUrl(sprintf($this->tokenUrl, $enterprise->app_id, $enterprise->app_secret, $code));
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
