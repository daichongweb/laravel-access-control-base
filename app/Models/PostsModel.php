<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'content',
        'collect_num',
        'share_num'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * posts多对多关联tags
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(TagsModel::class, 'posts_middle_tags', 'post_id', 'tag_id')->orderBy('id', 'desc')->withTimestamps();
    }

    /**
     * posts多对多关联uploads
     */
    public function covers(): BelongsToMany
    {
        return $this->belongsToMany(UploadsModel::class, 'posts_middle_uploads', 'post_id', 'upload_id')->orderBy('id', 'desc')->withTimestamps();
    }

    /**
     * 发布人一对一关联
     * @return HasOne
     */
    public function member(): HasOne
    {
        return $this->hasOne(MemberModel::class, 'id', 'member_id');
    }

    public function viewMembers(): HasMany
    {
        return $this->hasMany(WechatMemberViewLogsModel::class, 'post_id', 'id');
    }
}
