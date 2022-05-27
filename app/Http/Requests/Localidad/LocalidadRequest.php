<?php

namespace App\Http\Requests\Localidad;

use Illuminate\Foundation\Http\FormRequest;

class LocalidadRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nombre' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Localidad es requerida',
        ];
    }
}
