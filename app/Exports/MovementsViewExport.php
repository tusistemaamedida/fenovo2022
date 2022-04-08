<?php

namespace App\Exports;

use App\Models\Movement;
use App\Traits\OriginDataTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class MovementsViewExport implements FromView
{
    use OriginDataTrait;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        switch ($this->request->tipo) {
            case 'ENTRADA':
                $arrTypes = ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
                break;
            case 'SALIDA':
                $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
                break;
            case 'TODOS':
                $arrTypes = ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
                break;
        }

        $movements = Movement::whereIn('type', $arrTypes)
            ->whereBetween(DB::raw('DATE(date)'), [$this->request->desde, $this->request->hasta])
            ->orderBy('id', 'ASC')->get();

        $arrMovements = [];
        foreach ($movements as $movement) {
            foreach ($movement->movement_products as $movement_product) {
                if (!($movement_product->entidad_tipo == 'C')) {
                    if ($movement_product->entry > 0) {
                        $objMovement = new stdClass();

                        $store_type = DB::table('stores')->where('id', $movement->from)->select('store_type')->pluck('store_type')->first();
                        $cod_tienda = DB::table('stores')->where('id', $movement_product->entidad_id)->select('cod_fenovo')->pluck('cod_fenovo')->first();

                        $objMovement->origen      = ($store_type == 'N') ? 'DEP_CEN' : 'DEP_PAN';
                        $objMovement->id          = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = ($this->request->tipo == 'SALIDA') ? 'E' : 'S';
                        $objMovement->codtienda   = str_pad($cod_tienda, 3, '0', STR_PAD_LEFT);
                        $objMovement->codproducto = str_pad($movement_product->product->cod_fenovo, 4, '0', STR_PAD_LEFT);
                        $objMovement->cantidad    = $movement_product->bultos;
                        array_push($arrMovements, $objMovement);
                    }
                }
            }
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrMovements), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.movimientos', compact('arrMovements', 'data'));
    }
}
