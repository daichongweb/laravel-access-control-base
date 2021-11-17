<?php

namespace App\Services;

use App\Models\SettingsModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SettingService
{

    /**
     * 根据名称获取配置
     * @param $name
     * @return Builder|Model|object|null
     */
    public function getSettingByName($name)
    {
        return SettingsModel::query()->where('name', $name)->first();
    }
}
