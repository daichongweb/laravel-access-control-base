<?php

namespace App\Http\Requests;

use App\Models\User;

/**
 * 登录验证器
 */
class LoginRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'mobile_phone' => 'required|min:11',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required|in:mobileLogin,emailLogin'
        ];
    }

    public function messages(): array
    {
        return [
            'mobile_phone.required' => '手机号不能为空',
            'mobile_phone.min' => '手机号格式错误',
            'email.required' => '邮箱不能为空',
            'email.email' => '邮箱格式错误',
            'password.required' => '密码不能为空',
            'type.required' => '请选择登录方式',
            'type.in' => '登录方式错误'
        ];
    }

    public $scenes = [
        'mobileLogin' => ['mobile_phone'],
        'emailLogin' => ['email']
    ];
}
