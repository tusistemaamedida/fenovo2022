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
            'razon_social' => 'required',
            'cod_fenovo' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'razon_social.required'   => 'Razon social de la tienda es requerido!',
            'cod_fenovo.required'   => 'Cod Fenovo es requerido!',
        ];
    }
}
