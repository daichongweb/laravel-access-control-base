<?php

namespace App\Models;

use DateTimeInterface;
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

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
