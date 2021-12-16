<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class RuleRequest extends BaseRequest
{
    public function rules(): array
    {
        $id = $this->get('id');
        return [
            'id' => 'required|exists:rules,id',
            'name' => 'required|max:64|min:2|unique:rules,name,' . $id,
            'route' => 'required|max:128|min:2|unique:rules,route,' . $id,
            'parent_id' => 'required|exclude_if:parent_id,0|exists:rules,id',
            'rule_ids' => ['required', 'array', Rule::exists('rules', 'id')],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '请填写规则名',
            'name.max' => '规则名最大长度为64个文字',
            'name.min' => '规则名最小长度为2个文字',
            'name.unique' => '规则名已存在',
            'route.required' => '请填写路由',
            'route.max' => '路由最大长度为128个字符',
            'route.min' => '路由最小长度为4个字符',
            'route.unique' => '路由已存在',
            'parent_id.exists' => '上级路由不存在',
            'id.required' => '权限ID不能为空',
            'id.exists' => '权限ID不存在',
            'rule_ids.required' => '权限ID不能为空',
            'rule_ids.array' => '权限ID参数类型错误',
            'rule_ids.exists' => '权限不存在'
        ];
    }

    public $scenes = [
        'edit' => ['id', 'rule_name', 'route', 'parent_id'],
        'create' => ['rule_name', 'route', 'parent_id'],
        'change-status' => ['rule_ids']
    ];
}
