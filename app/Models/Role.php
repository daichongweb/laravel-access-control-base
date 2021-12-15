<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * 角色模型
 */
class Role extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'status'
    ];

    /**
     * 一个角色对应多个规则，通过roles_middle_rules中间表关联
     * @return BelongsToMany
     */
    public function rules(): BelongsToMany
    {
        return $this->belongsToMany(Rule::class, 'roles_middle_rules', 'role_id', 'rule_id');
    }
}
