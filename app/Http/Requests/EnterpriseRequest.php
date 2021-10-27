<?php

namespace App\Http\Requests;

/**
 * 企业信息提交验证器
 */
class EnterpriseRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|min:2|max:64|unique:App\Models\EnterpriseModel,name',
            'corp_id' => 'required|max:24|unique:App\Models\EnterpriseModel,corp_id',
            'corp_secret' => 'required|max:64',
            'app_id' => 'required|max:24||unique:App\Models\EnterpriseModel,app_id',
            'app_secret' => 'required|max:24'
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => '企业名称已被注册',
            'name.required' => '企业名称不能为空',
            'name.min' => '企业名称最少为2个字符',
            'name.max' => '企业名称最多为64个字符',
            'corp_id.required' => '企业微信id不能为空',
            'corp_secret.required' => '企业微信密钥不能为空',
            'app_id' => '公众号id不能为空',
            'app_secret' => '公众号密钥不能为空',
            'corp_id.unique' => '企业微信id已存在',
            'app_id.unique' => '公众号id已存在',
        ];
    }
}
