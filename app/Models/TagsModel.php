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
        'member_id'
    ];

    protected $hidden = [
        'member_id',
        'created_at',
        'updated_at'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
