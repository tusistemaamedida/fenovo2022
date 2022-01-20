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
            'plistproveedor'=> 'required|numeric',
            'descproveedor' => 'nullable|numeric',
            'mupfenovo'     => 'nullable|numeric',
            'contribution_fund' => 'nullable|numeric',
            'tasiva'    => 'nullable|numeric',
            'muplist2'  => 'nullable|numeric',
            'muplist2'  => 'nullable|numeric',
            'p1tienda'  => 'nullable|numeric',
            'descp1'    => 'nullable|numeric',
            'p2tienda'  => 'nullable|numeric',
            'descp2'    => 'nullable|numeric',
        ];
    }

    public function messages(){
        return [
            'plistproveedor.required'   => 'El precio proveedor es requerido!',
            'plistproveedor.numeric'    => 'El precio proveedor debe ser numérico!',
            'descproveedor.numeric'     => 'El desc. proveedor debe ser numérico!',
            'mupfenovo.numeric'         => 'El Markup Fenovo debe ser numérico!',
            'contribution_fund.numeric' => 'El Fondo contribución debe ser numérico!',
            'tasiva.numeric'            => 'El IVA debe ser numérico!',
            'muplist1.numeric'          => 'El Markup lista 1 debe ser numérico!',
            'muplist2.numeric'          => 'El Markup lista 2 debe ser numérico!',
            'p1tienda.numeric'          => 'El Precio tienda 1 debe ser numérico!',
            'descp1.numeric'            => 'El Desc. mayorista debe ser numérico!',
            'p2tienda.numeric'          => 'El Precio tienda 2 debe ser numérico!',
            'descp2.numeric'            => 'El Desc. mayorista debe ser numérico!',
        ];
    }
}
