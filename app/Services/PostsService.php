<?php

namespace App\Services;

use App\Models\PostsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostsService
{
    /**
     * 获取某个用户置顶的文章
     * @param $memberId
     * @return Builder|Model|object|null
     */
    public function getTopByMemberId($memberId)
    {
        return PostsModel::query()
            ->where('member_id', $memberId)
            ->where('is_top', PostsModel::TOP)
            ->first();
    }

    /**
     * 获取某个用户的某篇文章
     * @param $postId
     * @param $memberId
     * @return Builder|Model|object|null
     */
    public function getByMemberId($postId, $memberId)
    {
        return PostsModel::query()
            ->where('id', $postId)
            ->where('member_id', $memberId)
            ->first();
    }
}
