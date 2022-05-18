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
            $destino_id = ($destino->cod_fenovo) ? $destino->cod_fenovo : 'CLI_' . $destino->id;

            if ($movimiento->invoice) {
                $explodes = explode('-', $movimiento->invoice->voucher_number);
                $ptoVta   = str_pad((int)$explodes[0], 4, '0', STR_PAD_LEFT);
            }

            if ($movimiento->invoice) {
                $importe = $movimiento->invoice->imp_neto;
            } else {
                $importe = '0.0';
            }

            /* 1  */ $objMovimiento->id         = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            /* 2  */ $objMovimiento->fecha      = date('d/m/Y', strtotime($movimiento->date));
            /* 3  */ $objMovimiento->destino_id = str_pad($destino_id, 3, '0', STR_PAD_LEFT);
            /* 4  */ $objMovimiento->destino    = $movimiento->To($movimiento->type);
            /* 5  */ $objMovimiento->items      = count(MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->get());
            /* 6  */ $objMovimiento->tipo       = ($movimiento->type == 'VENTACLIENTE') ? 'VENTA' : $movimiento->type;
            /* 7  */ $objMovimiento->kgrs       = $movimiento->totalKgrs();
            /* 8  */ $objMovimiento->bultos     = MovementProduct::whereMovementId($movimiento->id)->where('egress', '>', 0)->sum('bultos');
            /* 9  */ $objMovimiento->flete      = ($movimiento->hasFlete()) ? $movimiento->getFlete()->neto105 + $movimiento->getFlete()->neto21 : '0.0';
            /* 10 */ $objMovimiento->neto       = $importe;
            /* 11 */ $objMovimiento->factura    = ($movimiento->invoice) ? $ptoVta . '-' . $explodes[1] : '0.0';
            /* 12 */ $objMovimiento->panamaneto = ($movimiento->getPanama()) ? $movimiento->getPanama()->neto105 + $movimiento->getPanama()->neto21 : '0.0';
            /* 13 */ $objMovimiento->panama1    = ($movimiento->hasPanama()) ? $movimiento->getPanama()->orden : '0.0';
            /* 14 */ $objMovimiento->panama2    = ($movimiento->hasFlete()) ? $movimiento->getFlete()->orden : '0.0';
            /* 15 */ $objMovimiento->franquicia = ($destino->cod_fenovo) ? 'franquicia' : 'no franquicia';

            array_push($arrMovimientos, $objMovimiento);
        }

        $anio = date('Y', time());
        $mes  = date('m', time());
        $dia  = date('d', time());
        $hora = date('H', time());
        $min  = date('i', time());

        $registros = str_pad(count($arrMovimientos), 6, '0', STR_PAD_LEFT);
        $data      = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.ordenConsolidadas', compact('arrMovimientos', 'data'));
    }
}
