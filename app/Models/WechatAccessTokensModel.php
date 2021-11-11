<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 微信用户授权表
 */
class WechatAccessTokensModel extends Model
{
    use HasFactory;

    protected $table = 'wechat_access_tokens';

    protected $fillable = [
        'enterprise_id',
        'access_token',
        'expires_in',
        'refresh_token',
        'openid',
        'scope',
        'unionid'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
