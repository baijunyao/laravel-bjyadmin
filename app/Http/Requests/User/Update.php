<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class Update extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //获取id
        $ids = request()->only('id', 'uid', 'user_id');
        $id = current(array_filter($ids));
        return [
            'name' => 'filled|unique:users,name,'.$id,
            'phone' => 'unique:users,phone,'.$id,
            'email' => 'filled|email|unique:users,email,'.$id,
        ];
    }


}
