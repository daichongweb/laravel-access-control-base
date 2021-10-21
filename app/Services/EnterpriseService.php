<?php

namespace App\Services;

use App\Data\EnterpriseRedis;
use App\Exceptions\ApiException;

/**
 * 企业服务
 */
class EnterpriseService
{
    private $get_token = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s';

    /**
     * 获取access_token
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function getToken()
    {
        $token = EnterpriseRedis::get();
        if (!$token) {
            $curlService = new CurlService();
            $curlService->setToArray(true);
            $curlService->setUrl(sprintf($this->get_token, env('CORPID'), env('PROVIDERSERET')));
            $curlService->setMethod('get');
            $curlService->setData([]);
            $response = $curlService->request();
            if ($response['errcode']) {
                throw new ApiException($response['errmsg'], $response['errcode']);
            }
            $token = $response['access_token'];
            EnterpriseRedis::set($token, $response['expires_in']);
        }

        return $token;
    }
}
