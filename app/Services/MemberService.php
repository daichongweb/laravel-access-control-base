<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 企业服务人员管理
 */
class MemberService extends BaseService
{
    public $follow = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_follow_user_list?access_token=%s';

    /**
     * 获取配置了客户联系功能的成员列表
     * @throws ApiException
     */
    public function followUserList()
    {
        $curlService = new CurlService();
        $curlService->setUrl(sprintf($this->follow, $this->token));
        $curlService->setMethod('get');
        $curlService->setData([]);
        return $curlService->request();
    }
}
