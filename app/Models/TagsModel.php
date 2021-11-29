<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsModel extends Model
{
    use HasFactory;

    protected $table = 'tags';

    protected $fillable = [
        'name',
        'member_id',
        'enterprise_id'
    ];

    protected $hidden = [
        'member_id',
        'created_at',
        'updated_at',
        'enterprise_id'
    ];
}
