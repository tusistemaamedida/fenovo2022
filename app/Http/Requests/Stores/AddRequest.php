<?php

namespace App\Http\Requests\Stores;

use Illuminate\Foundation\Http\FormRequest;

class AddRequest extends FormRequest
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
            'cod_fenovo' => 'required',
            'fantasy_name' => 'required',
        ];
    }

    public function messages(){
        return [
            'cod_fenovo.required'   => 'Cod Fenovo es requerido!',
            'fantasy_name.required'   => 'El nombre de la Tienda es requerido!',
        ];
    }
}
