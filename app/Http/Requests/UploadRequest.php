<?php

namespace App\Http\Requests;

/**
 * 上传验证器
 */
class UploadRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'image' => 'required|mimes:jpeg,png,jpeg,gif|max:2048|dimensions:min_width=200,min_height=200,max_width=1000,max_height=1000'
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '请上传图片',
            'image.mimes' => '图片必须是 jpeg, jpg, png, gif 格式的图片',
            'image.max' => '图片过大',
            'image.dimensions' => '图片的尺寸错误，宽和高需要200px以上，1000px以下'
        ];
    }
}
