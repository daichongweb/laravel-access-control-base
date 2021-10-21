<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 客户群
 */
class CustomerGroupService
{
    private $group_chat = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=%s';

    private $group_info = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=%s&external_userid=%s&cursor=%s';

    public $token;

    /**
     * 获取客户所有群ID
     * @throws ApiException
     */
    public function groupList($cursor = '')
    {
        $curl = new CurlService();
        $curl->setUrl(sprintf($this->group_chat, $this->token));
        $curl->setMethod('post');
        $curl->setData([
            'status_filter' => 0,
            'cursor' => $cursor,
            'limit' => 10
        ]);
        $curl->setIsJson(true);
        $curl->setToArray(true);
        return $curl->request();
    }

    /**
     * 客户群详情
     * @param $userId
     * @param string $cursor
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function groupInfo($userId, string $cursor = '')
    {
        $curl = new CurlService();
        $curl->setUrl(sprintf($this->group_info, $this->token, $userId, $cursor));
        $curl->setMethod('get');
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
