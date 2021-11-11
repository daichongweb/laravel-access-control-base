<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
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

    public function token(): HasOne
    {
        return $this->hasOne(WechatAccessTokensModel::class, 'openid', 'openid');
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
