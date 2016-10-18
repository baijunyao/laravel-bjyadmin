<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

class Request extends FormRequest
{

    /**
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




}
