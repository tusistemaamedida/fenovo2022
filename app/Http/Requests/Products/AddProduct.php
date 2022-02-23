<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class AddProduct extends FormRequest
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

    public function rules()
    {
        return [
            'name'           => 'required',
            'categorie_id'   => 'required',
            'cod_fenovo'     => 'required|unique:products,cod_fenovo|numeric',
            'proveedor_id'   => 'required',
            'unit_type'      => 'required',
            'unit_weight'    => 'required|numeric',
            'plistproveedor' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required'           => 'El nombre del producto es requerido!',
            'categorie_id.required'   => 'La categoría  del producto es requerida!',
            'cod_fenovo.required'     => 'El código fenovo es requerido!',
            'cod_fenovo.unique'       => 'El código fenovo ya existe!',
            'cod_fenovo.numeric'      => 'El código fenovo debe ser numérico!',
            'proveedor_id.required'   => 'El proveedor del producto es requerido!',
            'unit_type.required'      => 'La únidad de medida del producto es requerida!',
            'unit_weight.required'    => 'El peso del producto es requerido!',
            'unit_weight.numeric'     => 'El peso del producto debe ser numérico!',
            'type_package.required'   => 'La fragilidad del producto es requerida!',
            'net_weight.required'     => 'El Peso bulto neto del producto es requerido!',
            'net_weight.numeric'      => 'El Peso bulto neto del producto debe ser numérico!',
            'plistproveedor.required' => 'El precio del proveedor es requerido!',
            'plistproveedor.numeric'  => 'El precio del proveedor debe ser numérico!',
        ];
    }
}
