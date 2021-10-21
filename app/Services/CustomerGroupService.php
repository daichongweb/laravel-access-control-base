<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 客户群
 */
class CustomerGroupService
{
    private $group_chat = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=%s';

    private $group_info = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get?access_token=%s';

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
     * @param $chatId
     * @return false|mixed|string|null
     * @throws ApiException
     */
    public function groupInfo($chatId)
    {
        $curl = new CurlService();
        $curl->setUrl(sprintf($this->group_info, $this->token));
        $curl->setMethod('post');
        $curl->setIsJson(true);
        $curl->setData([
            "chat_id" => $chatId,
            "need_name" => 1
        ]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
