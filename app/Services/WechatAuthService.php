<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 微信授权服务
 */
class WechatAuthService
{
    private $tokenUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code';

    private $userInfoUrl = 'https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN';

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

    /**
     * 获取用户详细信息
     * @param $accessToken
     * @param $openId
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function getUserInfo($accessToken, $openId)
    {
        $curl = new CurlService();
        $curl->setMethod('get');
        $curl->setUrl(sprintf($this->userInfoUrl, $accessToken, $openId));
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
