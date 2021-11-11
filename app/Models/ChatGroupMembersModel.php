<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 群成员列表
 */
class ChatGroupMembersModel extends Model
{
    use HasFactory;

    protected $table = 'chat_group_members';

    protected $fillable = [
        'user_id',
        'type',
        'join_scene',
        'invitor',
        'group_nickname',
        'name',
        'join_time',
        'is_admin',
        'enterprise_id',
        'member_id',
        'info_id'
    ];

    /**
     * 自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
