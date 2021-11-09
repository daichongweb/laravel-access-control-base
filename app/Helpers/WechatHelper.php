<?php

namespace App\Helpers;

class WechatHelper
{
    /**
     * jsapi_ticket签名
     * @param array $parameter
     * @return string
     */
    public static function ticketSign(array $parameter): string
    {
        ksort($parameter);
        $str = http_build_str($parameter);
        return sha1($str);
    }
}
