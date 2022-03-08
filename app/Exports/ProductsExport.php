<?php

namespace App\Exports;

use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;

class ProductsExport implements FromArray
{
    use Exportable, SerializesModels;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array():array
    {
        $arrProductos = [];

        $productos = DB::table('products as t1')
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->join('product_descuentos as t4', 't1.cod_descuento', '=', 't4.codigo')
            ->select(
                't1.cod_fenovo',
                't1.cod_proveedor',
                't3.name as proveedor',
                't1.name',
                't2.plistproveedor',
                't2.descproveedor',
                't2.costfenovo',
                't2.mupfenovo',
                't2.plist0neto',
                't2.mup1',
                't2.p1may',
                't2.mupp1may',
                't2.p1tienda',
                't2.mupp1may',
                't2.cantmay1',
                't2.descp1',
                't2.tasiva',
                't1.barcode',
                't1.unit_package',
                't1.unit_type',
                't1.unit_weight',
                't2.mup2',
                't2.p2tienda',
                't1.package_palet',
                't1.package_row',
                't4.codigo',
            )
            ->get();

        foreach ($productos as $producto) {
            $objProducto = new stdClass();

            $objProducto->cod_fenovo     = (int)$producto->cod_fenovo;
            $objProducto->cod_proveedor  = $producto->cod_proveedor;
            $objProducto->proveedor      = $producto->proveedor;
            $objProducto->name           = $producto->name;
            $objProducto->plistproveedor = $producto->plistproveedor;
            $objProducto->descproveedor  = $producto->descproveedor;
            $objProducto->costfenovo     = $producto->costfenovo;
            $objProducto->mupfenovo      = $producto->mupfenovo;
            $objProducto->plist0neto     = $producto->plist0neto;
            $objProducto->mup1           = $producto->mup1;
            $objProducto->p1may          = $producto->p1may;
            $objProducto->mupp1may       = $producto->mupp1may;
            $objProducto->p1tienda       = $producto->p1tienda;
            $objProducto->mupp1may       = $producto->mupp1may;
            $objProducto->cantmay1       = $producto->cantmay1;
            $objProducto->descp1         = $producto->descp1;
            $objProducto->tasiva         = $producto->tasiva;
            $objProducto->barcode        = $producto->barcode;
            $objProducto->unit_package   = $producto->unit_package;
            $objProducto->unit_type      = $producto->unit_type;
            $objProducto->unit_weight    = $producto->unit_weight;
            $objProducto->mup2           = $producto->mup2;
            $objProducto->p2tienda       = $producto->p2tienda;
            $objProducto->package_palet  = $producto->package_palet;
            $objProducto->package_row    = $producto->package_row;
            $objProducto->codigo         = $producto->codigo;

            array_push($arrProductos, $objProducto);
        }

        return $arrProductos;
    }
}
