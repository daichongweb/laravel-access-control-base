<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 素材和图片的关联表
 */
class PostsMiddleUploadModel extends Model
{
    use HasFactory;

    protected $table = 'posts_middle_upload';
}
