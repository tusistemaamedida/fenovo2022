<?php

namespace App\Http\Requests\Proveedors;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'cuit' => 'required|string|min:11|max:11|cuil|unique:proveedors',
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cuit.required' => 'El cuit es requerido!',
            'cuil.cuil'     => 'El nro de cuit no es válido !',
            'name.required' => 'Razon social es requerida',
        ];
    }
}
