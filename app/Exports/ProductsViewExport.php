<?php

namespace App\Exports;

use App\Models\OfertaStore;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $productos = DB::table('products as t1')
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->leftJoin('product_descuentos as t4', 't1.cod_descuento', '=', 't4.codigo')
            ->select(
                't1.id',
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
                't4.codigo'
            )
            ->where('t1.active', 1)
            ->get();

        $arrProductos = [];

        $hoy       = Carbon::parse(now())->format('Y-m-d');

        foreach ($productos as $producto) {
            
            $oferta = DB::table('products as t1')
            ->join('session_ofertas as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->leftJoin('product_descuentos as t4', 't1.cod_descuento', '=', 't4.codigo')
            ->select(
                't1.id',
                't2.id as oferta_id',
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
                't4.codigo'
            )
            ->where('t1.id', $producto->id)
            ->where('t2.fecha_desde', '<=', $hoy)
            ->where('t2.fecha_hasta', '>=', $hoy)
            ->first();

            // Si existe la oferta del Producto
            if ($oferta) {
                $ofertaStore = OfertaStore::where('session_id', $oferta->oferta_id)->first();
                // Si existe para alguna Store, entonces es una excepción
                if (!$ofertaStore) {
                    $producto = $oferta;
                }
            }

            array_push($arrProductos, $producto);
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrProductos), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.productos', compact('arrProductos', 'data'));
    }
}
