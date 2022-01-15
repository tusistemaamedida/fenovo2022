<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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

    public function rules(){
        return [
            'name' => 'required',
            'email' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required'   => 'El nombre del usuario es requerido!',
            'email.required'   => 'El email del usaurio es requerido!',
        ];
    }
}
