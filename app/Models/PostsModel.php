<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 素材模型
 */
class PostsModel extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'enterprise_id',
        'member_id',
        'title',
        'cover',
        'content',
        'collect_num',
        'share_num'
    ];
}
