<?php

namespace App\Http\Requests\Proveedors;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'cuit' => 'required|string|min:11|max:11|cuit|unique:proveedors,cuit,' . $this->proveedor_id,
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'cuit.required' => 'El cuit es requerido!',
            'cuit.cuil'     => 'El nro de cuit no es válido !',
            'cuit.unique'   => 'El cuit se encuentra repetido !',
            'name.required' => 'Razon social es requerida',
        ];
    }
}
