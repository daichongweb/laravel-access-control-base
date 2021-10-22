<?php

namespace App\Http\Requests;

use App\Exceptions\ApiException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends FormRequest
{
    public $scenes = [];
    public $currentScene;
    public $autoValidate = false;

    public function authorize(): bool
    {
        return true;
    }

    /**
     * 设置场景
     * @param $scene
     * @return $this
     */
    public function scene($scene): BaseRequest
    {
        $this->currentScene = $scene;
        return $this;
    }


    /**
     * 覆盖自动验证方法
     * @throws ApiException
     */
    public function validateResolved()
    {
        if ($this->autoValidate) {
            $this->handleValidate();
        }
    }

    /**
     * @throws ApiException
     */
    public function validate($scene = '')
    {
        if ($scene) {
            $this->currentScene = $scene;
        }
        $this->handleValidate();
    }

    /**
     * 根据场景获取规则
     * @return array|mixed
     */
    public function getRules()
    {
        $rules = $this->container->call([$this, 'rules']);
        $newRules = [];
        if ($this->currentScene && isset($this->scenes[$this->currentScene])) {
            $sceneFields = is_array($this->scenes[$this->currentScene])
                ? $this->scenes[$this->currentScene] : explode(',', $this->scenes[$this->currentScene]);
            foreach ($sceneFields as $field) {
                if (array_key_exists($field, $rules)) {
                    $newRules[$field] = $rules[$field];
                }
            }
            return $newRules;
        }
        return $rules;
    }

    /**
     * 覆盖设置 自定义验证器
     * @param $factory
     * @return mixed
     */
    public function validator($factory)
    {
        return $factory->make(
            $this->validationData(), $this->getRules(),
            $this->messages(), $this->attributes()
        );
    }

    /**
     * @throws ApiException
     */
    protected function handleValidate()
    {
        $instance = $this->getValidatorInstance();
        if ($instance->fails()) {
            $this->failedValidation($instance);
        }
        $this->passedValidation();
    }

    /**
     * @throws ApiException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new ApiException($validator->errors()->first());
    }
}
