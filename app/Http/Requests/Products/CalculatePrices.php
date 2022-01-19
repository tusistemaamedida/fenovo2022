<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class CalculatePrices extends FormRequest
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
            'plistproveedor' => 'required|numeric',
            'descproveedor' => 'nullable|numeric',
            'mupfenovo' => 'nullable|numeric',
            'contribution_fund' => 'nullable|numeric',
        ];
    }

    public function messages(){
        return [
            'plistproveedor.required' => 'El precio proveedor es requerido!',
            'plistproveedor.numeric'  => 'El precio proveedor debe ser numérico!',
            'descproveedor.numeric'   => 'El desc. proveedor debe ser numérico!',
            'mupfenovo.numeric'       => 'El Markup Fenovo debe ser numérico!',
            'contribution_fund.numeric' => 'El Fondo contribución debe ser numérico!',
        ];
    }
}
