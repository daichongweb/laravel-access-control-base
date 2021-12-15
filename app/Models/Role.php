<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
