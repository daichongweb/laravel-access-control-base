<?php

namespace App\Models;

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
        'expires_id',
        'refresh_token',
        'open_id',
        'scope'
    ];
}