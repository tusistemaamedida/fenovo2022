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
        $arrTypes  = ($this->request->tipo) ? [$this->request->tipo] : ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movements = Movement::whereIn('type', $arrTypes)
            ->whereBetween(DB::raw('DATE(date)'), [$this->request->desde, $this->request->hasta])
            ->orderBy('id', 'ASC')->get();

        $arrMovements = [];
        foreach ($movements as $movement) {
            foreach ($movement->movement_products as $movement_product) {
                if (!($movement_product->entidad_tipo == 'C')) {
                    $objMovement              = new stdClass();
                    $objMovement->id          = $movement_product->id;
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = ($movement_product->egress > 0) ? 'S' : 'E';
                    $objMovement->codtienda   = DB::table('stores')->where('id', $movement_product->entidad_id)->select('cod_fenovo')->pluck('cod_fenovo')->first();
                    $objMovement->codproducto = $movement_product->product->cod_fenovo;
                    $objMovement->cantidad    = ($movement_product->egress > 0) ? $movement_product->egress : $movement_product->entry;
                    array_push($arrMovements, $objMovement);
                }
            }
        }
        return view('exports.movimientos', compact('arrMovements'));
    }
}
