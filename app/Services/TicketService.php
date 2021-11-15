<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Models\EnterpriseModel;

/**
 * 微信jsapi_ticket服务
 */
class TicketService
{
    private $url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi';

    private $accessToken = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s';

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

    /**
     * @throws ApiException
     */
    public function accessToken($enterpriseModel)
    {
        $curlService = new CurlService();
        $curlService->setUrl(sprintf($this->accessToken, $enterpriseModel->app_id, $enterpriseModel->app_secret));
        $curlService->setMethod('get');
        $curlService->setData([]);
        $result = $curlService->request();
        if (isset($result['errcode']) && $result['errcode'] > 0) {
            throw new ApiException($result['errmsg']);
        }
        return $result;
    }
}
