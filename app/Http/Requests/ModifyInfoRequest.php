<?php

namespace App\Http\Requests;


class ModifyInfoRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|max:24',
            'avatar' => 'required|max:254|url'
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => '昵称不能为空',
            'avatar.required' => '头像不能为空',
            'username.max' => '昵称最长为24个字符',
            'avatar.max' => '图片长度过大',
            'avatar.url' => '不是一个有效的头像地址'
        ];
    }
}
