<?php

namespace App\Http\Requests\Roles;

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
            'name' => 'required',
        ];
    }

    public function messages(){
        return [
            'name.required'   => 'El nombre es requerido!',
        ];
    }
}
