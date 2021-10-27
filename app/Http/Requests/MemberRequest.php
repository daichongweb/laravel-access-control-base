<?php

namespace App\Http\Requests;

/**
 *企业成员验证器
 */
class MemberRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'enterprise_id' => 'required|exists:enterprises,id',
            'corp_user_id' => 'required',
            'name' => 'required|min:4|max:64',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise_id.required' => '所属企业不能为空',
            'corp_user_id.required' => '企业微信用户ID不能为空',
            'name.required' => '登录账号不能为空',
            'name.min' => '登录账号至少4位字符',
            'name.max' => '登录账号最多64位字符',
            'email.email' => '邮箱错误',
            'password.required' => '密码不能为空',
            'password.min' => '密码至少5位字符'
        ];
    }

    public $scenes = [
        'bind' => ['corp_user_id', 'name', 'enterprise_id'],
        'create' => ['enterprise_id', 'name', 'password', 'email']
    ];
}
