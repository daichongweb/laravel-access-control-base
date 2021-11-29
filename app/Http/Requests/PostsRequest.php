<?php

namespace App\Http\Requests;


use Illuminate\Validation\Rule;

/**
 * 素材验证器
 */
class PostsRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'enterprise_id' => 'required|exists:App\Models\EnterpriseModel,id',
            'member_id' => 'required|exists:App\Models\MemberModel,id',
            'title' => 'required|max:64',
            'covers' => ['required', Rule::exists('uploads', 'id')],
            'content' => 'required',
            'tags' => ['required', Rule::exists('tags', 'id')],
            'is_public' => 'in:0,1'
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise_id.required' => '请先选择企业',
            'enterprise_id.exists' => '企业不存在',
            'member_id.required' => '请先登录',
            'member_id.exists' => '用户不存在',
            'title.required' => '标题不能为空',
            'title.max' => '标题长度不能超过64个字符',
            'covers.required' => '封面图不能为空',
            'covers.exists' => '封面图不存在',
            'content.required' => '素材内容不能为空',
            'tags.required' => '标签不能为空',
            'tags.exists' => '所选标签不存在',
            'is_public.in' => '是否公开参数类型错误'
        ];
    }
}
