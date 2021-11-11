<?php

namespace App\Models;

use DateTimeInterface;
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
     * 字段隐藏
     * @var string[]
     */
    protected $hidden = ['corp_secret', 'app_secret'];

    /**
     * 填充字段
     * @var string[]
     */
    protected $fillable = [
        'name', 'corp_id', 'corp_secret', 'app_id', 'app_secret'
    ];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->key = Str::random(32);
        });
    }
}
