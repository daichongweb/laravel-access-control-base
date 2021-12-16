<?php

namespace App\Services;

use App\Enums\CommonStatus;
use App\Models\Rule;

class RuleService
{
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
}
