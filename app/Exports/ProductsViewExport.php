<?php

namespace App\Exports;

use App\Models\ActualizacionPrecio;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View ;
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
        $desde = $this->request->desde;
        $hasta = $this->request->hasta;

        if ($desde == '' or $hasta == '') {
            $actualizacion = ActualizacionPrecio::orderBy('fecha', 'desc')->skip(1)->first();
            $desde         = $actualizacion->fecha;

            $actualizacion = ActualizacionPrecio::orderBy('fecha', 'desc')->first();
            $hasta         = $actualizacion->fecha;
        }
        $productos = DB::table('products as t1')
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->join('proveedors as t3', 't3.id', '=', 't1.proveedor_id')
            ->leftJoin('product_descuentos as t4', 't1.cod_descuento', '=', 't4.codigo')
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
            ->where('t1.active', 1)
            ->whereBetween(DB::raw('DATE(t2.updated_at)'), [$desde, $hasta])
            ->get();

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($productos), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.productos', compact('productos', 'data'));
    }
}
