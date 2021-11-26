<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 群列表
 */
class ChatGroupsModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'enterprise_id',
        'member_id',
        'chat_id',
        'chat_name',
        'status'
    ];

    protected $table = 'chat_groups';
}
