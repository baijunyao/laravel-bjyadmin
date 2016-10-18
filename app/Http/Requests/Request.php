<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Dingo\Api\Exception\ResourceException;

class Request extends FormRequest
{

    /**
     * 统一返回json格式的没有通过验证的错误信息
     *
     * {@inheritdoc}
     */
    protected function formatErrors(Validator $validator){
        $message = $validator->errors()->first();
        $data = [
            'status_code'=>500,
            'message'=>$message
        ];
        return $data;
    }

    /**
     * 返回具体没有通过验证的值
     *
     * @param Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        if($this->is(config('api.prefix') . '/*')) {
            $message = $validator->errors()->first();
            throw new ResourceException($message);
        }
        parent::failedValidation($validator);
    }


}
