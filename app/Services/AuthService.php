<?php

namespace App\Services;

use App\Exceptions\ApiException;

/**
 * 授权服务器
 */
class AuthService
{
    private $auth = 'https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=%s&code=%s';

    public $token;

    /**
     * 获取访问用户身份
     * @throws ApiException
     */
    public function user($code)
    {
        $curl = new CurlService();
        $curl->setUrl(sprintf($this->auth, $this->token, $code));
        $curl->setMethod('get');
        $curl->setData([]);
        $curl->setToArray(true);
        return $curl->request();
    }
}
