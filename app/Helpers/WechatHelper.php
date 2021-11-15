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
        $str = '';
        foreach ($parameter as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }
        return sha1(rtrim($str, '&'));
    }
}
