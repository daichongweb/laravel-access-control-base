<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MemberModel extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'members';

    /**
     * 自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'enterprise_id',
        'corp_user_id',
        'pid',
        'name',
        'email',
        'password',
        'avatar',
        'username'
    ];

    protected $hidden = ['password'];

    public function enterprise(): HasOne
    {
        return $this->hasOne(EnterpriseModel::class, 'id', 'enterprise_id');
    }
}
