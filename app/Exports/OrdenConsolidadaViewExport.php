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

        $movimientos = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('id');

        $arrMovimientos = [];

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            $objMovimiento->id      = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            $objMovimiento->fecha    = date('Y-m-d', strtotime($movimiento->date));
            $objMovimiento->destino = $movimiento->origenData($movimiento->type);
            $objMovimiento->items   = count(MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->get());
            $objMovimiento->tipo    = $movimiento->type;
            $objMovimiento->kgrs    = $movimiento->totalKgrs();
            $objMovimiento->bultos  = MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->sum('bultos');
            $objMovimiento->flete   = $movimiento->flete;
            $objMovimiento->neto    = ($movimiento->invoice) ?$movimiento->invoice->imp_neto: 0;

            array_push($arrMovimientos, $objMovimiento);
        }

        return view('exports.ordenConsolidadas', compact('arrMovimientos'));
    }
}
