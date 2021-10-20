<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 服务商相关服务
 */
class ProviderService
{
    // 获取服务商凭证 POST
    public $getProviderToken = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token';

    /**
     * @throws ApiException
     */
    public function getProviderToken()
    {
        $curl = new CurlService();
        return $curl->setUrl($this->getProviderToken)
            ->setData(
                [
                    'corpid' => env('CORPID'),
                    'provider_secret' => env('PROVIDERSERET')
                ]
            )
            ->setIsJson(true)
            ->setToArray(true)
            ->request();
    }
}
