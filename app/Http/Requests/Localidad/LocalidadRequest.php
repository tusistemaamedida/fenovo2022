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
            'nombre' => 'required|unique:localidades,nombre,' . $this->nombre,
            'departamento' => 'required',
            'provincia' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Informacion es requerida',
            'departamento.required' => 'Informacion es requerida',
            'provincia.required' => 'Informacion es requerida',
        ];
    }
}
