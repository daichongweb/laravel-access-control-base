<?php

namespace App\Services;

use App\Enums\CommonStatus;
use App\Models\RolesMiddleRules;
use App\Models\Rule;

class RuleService
{
    /*********************规则：启用/禁用*****************************/

    public function disable(array $ids): int
    {
        return $this->changeStatus($ids, CommonStatus::DISABLE);
    }

    public function enable(array $ids): int
    {
        return $this->changeStatus($ids, CommonStatus::ENABLE);
    }

    public function changeStatus(array $ids, int $status): int
    {
        return Rule::query()->whereIn('id', $ids)->update(['status' => $status]);
    }

    public function getRoutesByRoleIds($roleIds, $getTopCat = true): array
    {
        $routes = ['login:out'];
        $middles = RolesMiddleRules::query()->where('role_id', $roleIds)->get();
        if ($middles) {
            foreach ($middles as $middle) {
                if ($middle->rule) {
                    if (!$getTopCat && $middle->rule->parent_id == 0) {
                        continue;
                    }
                    array_push($routes, $middle->rule->route);
                }
            }
        }
        return $routes;
    }
}
