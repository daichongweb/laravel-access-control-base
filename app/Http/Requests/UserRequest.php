<?php

namespace App\Http\Requests;

class UserRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'old_pwd' => ['required', 'min:6'],
            'new_pwd' => ['required', 'min:6', 'confirmed'],
            'new_pwd_confirmation' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'old_pwd.required' => '请填写旧密码',
            'old_pwd.min' => '旧密码错误',
            'new_pwd.required' => '请填写新密码',
            'new_pwd.min' => '密码最小长度为6位',
            'new_pwd.confirmed' => '两次密码不一致',
            'user_id.required' => '用户ID不能为空',
            'user_id.exists' => '该用户不存在'
        ];
    }

    public $scenes = [
        'edit_pwd' => ['old_pwd', 'new_pwd', 'confirm_pwd'],
        'role-rule' => ['user_id']
    ];
}
