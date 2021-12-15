<?php

namespace App\Http\Requests;

/**
 * 登录验证器
 */
class LoginRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'name' => 'required|min:4',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required|in:name-login,email-login'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '账号不能为空',
            'name.min' => '账号格式错误',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'password.required' => '密码不能为空',
            'type.required' => '请选择登录方式',
            'type.in' => '登录方式错误'
        ];
    }

    public $scenes = [
        'name-login' => ['name'],
        'email-Login' => ['email']
    ];
}
