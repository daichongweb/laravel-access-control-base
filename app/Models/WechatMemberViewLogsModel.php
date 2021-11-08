<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 文章查看记录表
 */
class WechatMemberViewLogsModel extends Model
{
    use HasFactory;

    protected $table = 'wechat_member_view_logs';

    protected $fillable = [
        'enterprise_id',
        'wechat_member_id',
        'post_id'
    ];
}
