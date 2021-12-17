<?php

namespace App\Services;

class UserService
{
    public function useRoute($userId): array
    {
        $roleIds = (new RoleService())->getRoleIdsByUserId($userId);
        return (new RuleService())->getRoutesByRoleIds($roleIds, false);
    }
}
