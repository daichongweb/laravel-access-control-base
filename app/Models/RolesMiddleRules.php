<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RolesMiddleRules extends Model
{
    use HasFactory;

    public $table = 'roles_middle_rules';

    public $fillable = [
        'role_id',
        'rule_id'
    ];

    public function rule(): HasOne
    {
        return $this->hasOne(Rule::class, 'id', 'rule_id');
    }
}
