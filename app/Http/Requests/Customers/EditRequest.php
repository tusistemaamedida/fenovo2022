<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
{
    /**
     * 
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(){
        return [
            'razon_social' => 'required',
        ];
    }

    public function messages(){
        return [
            'razon_social.required'   => 'El nombre es requerido!',
        ];
    }
}
