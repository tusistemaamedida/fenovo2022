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
            'descproveedor' => 'nullable|numeric|max:99.9',
            'mupfenovo'     => 'nullable|numeric|max:99.9',
            'contribution_fund' => 'nullable|numeric|max:99.9',
            'tasiva'    => 'nullable|numeric',
            'muplist2'  => 'nullable|numeric|max:99.9',
            'muplist2'  => 'nullable|numeric|max:99.9',
            'p1tienda'  => 'nullable|numeric',
            'descp1'    => 'nullable|numeric|max:99.9',
            'p2tienda'  => 'nullable|numeric',
            'descp2'    => 'nullable|numeric',
        ];
    }

    public function messages(){
        return [
            'plistproveedor.required'   => 'El precio proveedor es requerido!',
            'plistproveedor.numeric'    => 'El precio proveedor debe ser numérico!',
            'descproveedor.numeric'     => 'El desc. proveedor debe ser numérico!',
            'descproveedor.max'         => 'El desc. proveedor debe ser maximo 100%!',
            'mupfenovo.numeric'         => 'El Markup Fenovo debe ser numérico!',
            'mupfenovo.max'         => 'El Markup Fenovo debe ser maximo 100%!',
            'contribution_fund.numeric' => 'El Fondo contribución debe ser numérico!',

            'contribution_fund.max' => 'El Fondo contribución debe ser maximo 100%!',

            'tasiva.numeric'            => 'El IVA debe ser numérico!',
            'muplist1.numeric'          => 'El Markup lista 1 debe ser numérico!',
            'muplist2.numeric'          => 'El Markup lista 2 debe ser numérico!',

            'muplist1.max'          => 'El Markup lista 1 debe ser maximo 100%!',
            'muplist2.max'          => 'El Markup lista 2 debe ser maximo 100%!',

            'p1tienda.numeric'          => 'El Precio tienda 1 debe ser numérico!',
            'descp1.numeric'            => 'El Desc. mayorista debe ser numérico!',
            'p2tienda.numeric'          => 'El Precio tienda 2 debe ser numérico!',
            'descp2.numeric'            => 'El Desc. mayorista debe ser numérico!',

            'descp1.max'            => 'El Desc. mayorista debe ser maximo 100%!',
            //'descp2.max'            => 'El Desc. mayorista debe ser maximo 100%!',
        ];
    }
}
