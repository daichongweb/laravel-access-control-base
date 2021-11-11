<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function post(): HasOne
    {
        return $this->hasOne(PostsModel::class, 'id', 'post_id');
    }
}
