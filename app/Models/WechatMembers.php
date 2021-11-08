<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * 微信用户表
 */
class WechatMembers extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'wechat_members';

    protected $fillable = [
        'enterprise_id',
        'openid',
        'nickname',
        'sex',
        'province',
        'city',
        'country',
        'headimgurl',
        'unionid'
    ];

    protected $hidden = [
        'openid',
        'unionid'
    ];
}
