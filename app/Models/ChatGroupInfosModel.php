<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *群详情信息
 */
class ChatGroupInfosModel extends Model
{
    use HasFactory;

    protected $table = 'chat_group_infos';

    protected $fillable = [
        'chat_id',
        'chat_name',
        'owner',
        'member_num',
        'admin_num',
        'create_time',
        'enterprise_id',
        'member_id'
    ];

    /**
     * 自动维护时间戳
     * @var bool
     */
    public $timestamps = true;
}
