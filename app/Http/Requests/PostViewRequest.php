<?php

namespace App\Http\Requests;

/**
 * 文章查看验证器
 */
class PostViewRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'enterprise_id' => 'required',
            'wechat_member_id' => 'required|exists:App\Models\WechatMembers,id',
            'id' => 'required||exists:App\Models\PostsModel,id'
        ];
    }

    public function messages(): array
    {
        return [
            'enterprise_id.required' => '企业不存在',
            'wechat_member_id.required' => '请先登录',
            'wechat_member_id.exists' => '用户不存在.2',
            'id.required' => '素材不存在.1',
            'id.exists' => '素材不存在.2',
        ];
    }
}
