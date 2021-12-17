<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersMiddleRoles extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'role_id'
    ];


}
