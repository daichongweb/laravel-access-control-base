<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * 素材模型
 */
class PostsModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'posts';

    const TOP = 1;
    const UN_TOP = 0;

    protected $fillable = [
        'enterprise_id',
        'member_id',
        'title',
        'content',
        'collect_num',
        'share_num',
        'is_top',
        'is_public'
    ];

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

    public function collect(): HasOne
    {
        return $this->hasOne(CollectsModel::class, 'post_id', 'id');
    }
}
