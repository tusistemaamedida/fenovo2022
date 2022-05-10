<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\MovementProduct;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class OrdenConsolidadaViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $movimientos = Movement::all()->whereIn('type', $arrTypes)->sortBy('id');

        $arrMovimientos = [];

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            $objMovimiento->id      = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            $objMovimiento->fecha    = date('Y-m-d', strtotime($movimiento->date));
            $objMovimiento->items   = count(MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->get());
            $objMovimiento->destino = $movimiento->To($movimiento->type,true);
            $objMovimiento->tipo    = $movimiento->type;
            $objMovimiento->kgrs    = $movimiento->totalKgrs();
            $objMovimiento->bultos  = MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->sum('bultos');
            $objMovimiento->flete   = $movimiento->flete;
            $objMovimiento->neto    = ($movimiento->invoice) ?$movimiento->invoice->imp_neto: 0;

            array_push($arrMovimientos, $objMovimiento);
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrMovimientos), 4, '0', STR_PAD_LEFT);
        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.ordenConsolidadas', compact('arrMovimientos', 'data'));
    }
}
