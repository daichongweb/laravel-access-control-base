<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 文章和标签中间表
 */
class PostsMiddleTagsModel extends Model
{
    use HasFactory;

    protected $table = 'posts_middle_tags';

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
