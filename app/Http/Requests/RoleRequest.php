<?php

namespace App\Http\Requests;

use App\Enums\CommonStatus;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class RoleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'role_name' => 'required|max:64|min:2|unique:roles,name',
            'role_id' => ['required', $this->roleIdExists()],
            'rule_ids' => ['required', 'array', $this->ruleIdExists()],
            'role_ids' => ['required', 'array', $this->roleIdExists()],
        ];
    }

    public function messages(): array
    {
        return [
            'role_id.required' => '角色ID不能为空',
            'role_id.exists' => '角色不存在或被禁用',
            'rule_ids.required' => '权限参数类型错误',
            'role_name.required' => '角色名称不能为空',
            'role_name.min' => '角色名称至少2个文字',
            'role_name.max' => '角色名称最高64个文字',
            'role_name.unique' => '角色名称已存',
            'rule_ids.exists' => '权限不存在或已被禁用',
            'rule_ids.array' => '权限ID参数格式错误',
            'role_ids.required' => '角色ID不能为空',
            'role_ids.array' => '角色ID参数格式错误',
            'role_ids.exists' => '角色不存在或已被禁用'
        ];
    }

    public $scenes = [
        'create' => ['role_name', 'role_id'],
        'change-rule' => ['role_id', 'rule_ids'],
        'change-status' => ['role_ids']
    ];

    private function roleIdExists(): Exists
    {
        return Rule::exists('roles', 'id')->where('status', CommonStatus::ENABLE);
    }

    private function ruleIdExists(): Exists
    {
        return Rule::exists('rules', 'id')->where('status', CommonStatus::ENABLE);
    }
}
