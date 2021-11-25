<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WechatMemberViewTagsModel extends Model
{
    use HasFactory;

    protected $table = 'wechat_member_view_tags';

    protected $fillable = [
        'enterprise_id',
        'wechat_member_id',
        'tag_id',
        'view_num'
    ];

    protected static function booted()
    {
        // 修改时
        static::saving(function ($log) {
            $log->view_num += 1;
        });
        
        // 创建后
        static::created(function ($log) {
            TagsModel::query()->where('id', $log->tag_id)->increment('view_num', 1);
        });
    }
}
