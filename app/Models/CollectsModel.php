<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 企业成员收藏
 */
class CollectsModel extends Model
{
    use HasFactory;

    protected $table = 'collects';

    protected $fillable = [
        'post_id',
        'member_id'
    ];
}
