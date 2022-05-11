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
        $arrTypes       = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movimientos    = Movement::all()->whereIn('type', $arrTypes)->sortBy('id');
        $arrMovimientos = [];

        foreach ($movimientos as $movimiento) {
            $objMovimiento = new stdClass();

            // El destino puede venir una Tienda o un Cliente
            $destino    = Movement::find($movimiento->id)->To($movimiento->type, true);
            $destino_id = ($destino->cod_fenovo) ? $destino->cod_fenovo : $destino->id;
            
            $factura    = ($movimiento->invoice) ? $movimiento->invoice->voucher_number : 0;

            $objMovimiento->id         = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            $objMovimiento->fecha      = date('d/m/Y', strtotime($movimiento->date));
            $objMovimiento->items      = count(MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->get());
            $objMovimiento->destino_id = str_pad($destino_id, 3, '0', STR_PAD_LEFT);
            $objMovimiento->destino    = $movimiento->To($movimiento->type);
            $objMovimiento->tipo       = ($movimiento->type == 'VENTACLIENTE') ? 'VENTA' : $movimiento->type;
            $objMovimiento->kgrs       = $movimiento->totalKgrs();
            $objMovimiento->bultos     = MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->sum('bultos');
            $objMovimiento->flete      = $movimiento->flete;
            $objMovimiento->neto       = 0;
            $objMovimiento->factura    = $factura;

            array_push($arrMovimientos, $objMovimiento);
        }

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($arrMovimientos), 4, '0', STR_PAD_LEFT);
        $data      = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.ordenConsolidadas', compact('arrMovimientos', 'data'));
    }
}
