<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'role_name' => 'required|max:64|min:2|exists:roles,name',
            'role_id' => ['required', Rule::exists('roles', 'id')->where('status', 1)],
            'rule_ids' => 'required|array',
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
            'role_name.exists' => '角色名称已存在',
        ];
    }

    public $scenes = [
        'create' => ['role_name'],
        'change' => ['role_id', 'rule_ids']
    ];
}
