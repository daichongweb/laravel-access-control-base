<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 微信jsapi_ticket服务
 */
class TicketService
{
    private $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi';

    /**
     * 获取jsapi_ticket
     * @throws ApiException
     */
    public function get($accessToken)
    {
        $curlService = new CurlService();
        $curlService->setUrl(sprintf($this->url, $accessToken));
        $curlService->setMethod('get');
        $curlService->setData([]);
        return $curlService->request();
    }
}
