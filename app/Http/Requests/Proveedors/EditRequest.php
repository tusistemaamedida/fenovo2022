<?php

namespace App\Http\Requests\Proveedors;

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

    public function rules()
    {
        return [
            'name' => 'required',
            'cuit' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'Razon social es requerido',
            'cuit.required'   => 'El cuit es requerido!',
        ];
    }
}
