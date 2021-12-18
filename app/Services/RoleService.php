<?php

namespace App\Services;

use App\Models\Role;
use App\Models\RolesMiddleRules;
use App\Models\UsersMiddleRoles;
use Illuminate\Support\Collection;

class RoleService
{
    /*******************启用/禁用「角色」********************/

    public function disable(array $ids): int
    {
        return $this->changeStatus($ids, 0);
    }

    public function enable(array $ids): int
    {
        return $this->changeStatus($ids, 1);
    }

    public function changeStatus(array $ids, int $status): int
    {
        return Role::query()->whereIn('id', $ids)->update(['status' => $status]);
    }

    /*******************添加/删除「角色与权限关系」********************/

    public function addRule(int $roleId, array $ruleIds, $bindType = 'sync'): bool
    {
        if ($bindType == 'attach') {
            $oldRuleIds = $this->getRuleIdsByRoleId($roleId);
            $ruleIds = array_values(array_diff($ruleIds, $oldRuleIds->toArray()));
        }
        return $this->changeRule($roleId, $ruleIds, $bindType);
    }

    public function delRule(int $roleId, array $ruleIds): bool
    {
        return $this->changeRule($roleId, $ruleIds, 'detach');
    }

    public function changeRule(int $roleId, array $ruleIds, $fun): bool
    {
        $bool = false;
        if ($role = $this->findById($roleId)) {
            $bool = $role->rules()->$fun($ruleIds);
        }
        return (bool)$bool;
    }

    public function findById($roleId)
    {
        return Role::query()->find($roleId);
    }

    public function getRoleIdsByUserId($userId): Collection
    {
        return UsersMiddleRoles::query()->where('user_id', $userId)->pluck('role_id');
    }

    public function getRuleIdsByRoleId($roleId): Collection
    {
        return RolesMiddleRules::query()->where('role_id', $roleId)->pluck('rule_id');
    }
}
