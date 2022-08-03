<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function getModel()
    {
        return new Product();
    }

    protected function selectList()
    {
        return $this->newQuery()->with([
            'product_category',
            'proveedor',
            'senasa_definition',
            'product_descuento',
            'product_images',
            'product_nutricional',
            'product_price',
            'session_prices'
        ]);
    }

    public function paginate($cant)
    {
        return $this->selectList()
            ->orderBy('created_at', 'DESC')
            ->paginate($cant);
    }

    public function existCode($code_fenovo)
    {
        return $this->newQuery()->where('cod_fenovo', $code_fenovo)->exists();
    }

    public function getByProveedorIdPluck($proveedorId)
    {
        return Product::selectRaw('id, CONCAT(name," - ",cod_fenovo) as nombreCompleto')->where('proveedor_id', $proveedorId)->orderBy('name')->pluck('nombreCompleto', 'id');
    }

    public function search($term)
    {
        if(\Auth::user()->rol() != 'contable' ){
            $categorieIdBetween = [1,3];
        }else{
            $categorieIdBetween = [4,8];
        }

        return $this->newQuery()->select('id', 'name', 'barcode', 'cod_fenovo', 'unit_type','stock_f','stock_r','stock_cyo')
                    ->where('active', true)
                    ->whereBetween('categorie_id', $categorieIdBetween)
                    ->where(function ($query) use ($term) {
                        $query->orWhere('name', 'LIKE', '%' . $term . '%')
                              ->orWhere('cod_fenovo', 'LIKE', '%' . $term . '%');
                    })
                    ->get();
    }

    public function getByIdWith($id)
    {
        return $this->selectList()->where('id', $id)->first();
    }

    public function getByCodeFenovo($cod_fenovo)
    {
        return $this->selectList()->where('cod_fenovo', $cod_fenovo)->first();
    }
}
