<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UploadsModel extends Model
{
    use HasFactory;

    protected $table = 'uploads';

    protected $fillable = [
        'enterprise_id',
        'member_id',
        'file_path',
        'suffix',
        'service',
        'type'
    ];

    public function getFilePathAttribute($value): string
    {
        return env('ALI_DOMAIN') . $value;
    }

    protected $hidden = [
        'service',
        'type',
        'member_id',
        'enterprise_id'
    ];
}
