<?php

namespace App\Http\Requests\Stores;

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
            'description' => 'required',
            'cod_fenovo' => 'required',
            'cuit' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'description.required'   => 'Razon social de la tienda es requerido !',
            'cod_fenovo.required'   => 'Cod Fenovo es requerido !',
            'cuit.required'   => 'Cuit es requerido !',
        ];
    }
}
