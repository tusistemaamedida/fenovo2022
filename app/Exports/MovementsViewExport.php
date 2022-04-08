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
        $desde = $this->request->desde;
        $hasta = $this->request->hasta;

        $arrTipos   = ['VENTA', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEntrada = ['VENTA', 'TRASLADO'];

        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry')
            ->whereIn('t1.type', $arrTipos)
            ->whereBetween(DB::raw('DATE(date)'), [$desde, $hasta])
            ->where('t2.entidad_tipo', '!=', 'C')
            ->get();

        $arrMovements = [];

        foreach ($movimientos as $movement) {
            $store_type = DB::table('stores')->where('id', $movement->from)->select('store_type')->pluck('store_type')->first();

            $creado = false;

            if (in_array($movement->type, $arrEntrada)) {

                // Venta o traslado

                if ($movement->entry > 0) {
                    $objMovement              = new stdClass();
                    $creado                   = true;
                    $objMovement->origen      = ($store_type == 'N') ? 'DEP_CEN' : 'DEP_PAN';
                    $objMovement->id          = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = 'E';
                    $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                    $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                    $objMovement->cantidad    = $movement->bultos;
                }
            } else {

                // Analizar las devoluciones

                $tipo = ($movement->entry > 0) ? 'E' : 'S';

                $objMovement              = new stdClass();
                $creado                   = true;
                $objMovement->origen      = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->id          = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
                $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                $objMovement->tipo        = $tipo;
                $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                $objMovement->cantidad    = $movement->bultos;
            }

            if ($creado) {
                array_push($arrMovements, $objMovement);
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
