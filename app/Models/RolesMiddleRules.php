<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolesMiddleRules extends Model
{
    use HasFactory;

    public $table = 'roles_middle_rules';

    public $fillable = [
        'role_id',
        'rule_id'
    ];
}