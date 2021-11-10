<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function wechatMembers(): HasMany
    {
        return $this->hasMany(WechatMembers::class, 'id', 'wechat_member_id');
    }
}
