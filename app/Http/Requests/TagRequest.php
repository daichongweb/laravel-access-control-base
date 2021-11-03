<?php

namespace App\Http\Requests;

/**
 * 标签表单验证器
 */
class TagRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:4|unique:App\Models\TagsModel,name,member_id',
            'member_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '标签名不能为空',
            'name.max' => '标签名最长不能超过4个字符',
            'name.unique' => '标签名重复'
        ];
    }
}
