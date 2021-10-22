<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 客户相关服务
 */
class CustomerService extends BaseService
{
    private $infoUrl = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=%s&external_userid=%s&cursor=%s';

    /**
     * 获取客户详情
     * @throws ApiException
     */
    public function info($userId, $cursor = '')
    {
        $curl = new CurlService();
        $curl->setUrl(sprintf($this->infoUrl, $this->token, $userId, $cursor));
        $curl->setMethod('get');
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
