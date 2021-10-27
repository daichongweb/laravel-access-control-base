<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * 企业模型
 */
class EnterpriseModel extends Model
{
    use HasFactory;

    protected $table = 'enterprises';

    /**
     * 自动维护时间戳
     * @var bool
     */
    public $timestamps = true;

    /**
     * 填充字段
     * @var string[]
     */
    protected $fillable = [
        'name', 'corp_id', 'corp_secret', 'app_id', 'app_secret'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->key = Str::random(32);
        });
    }
}
