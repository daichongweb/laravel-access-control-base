<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberModel extends Model
{
    use HasFactory;

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
        'password'
    ];
}
