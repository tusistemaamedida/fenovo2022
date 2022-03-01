<?php

namespace App\Exports;

use App\Models\Movement;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;

class MovementsExport implements FromArray
{
    use Exportable, SerializesModels;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array():array
    {
        $arrTypes  = ($this->request->tipo) ? [$this->request->tipo] : ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movements = Movement::whereIn('type', $arrTypes)->whereBetween(DB::raw('DATE(date)'), [$this->request['desde'], $this->request['hasta']])->orderBy('id', 'ASC')->get();

        $arrMovements = [];
        foreach ($movements as $movement) {
            foreach ($movement->movement_products as $movement_product) {
                if ($movement->type == 'VENTACLIENTE' and $movement_product->egress > 0) {
                    $movement_product->store_id = 0;
                }

                $objMovement = new stdClass();

                $objMovement->id          = $movement_product->id;
                $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                $objMovement->tipo        = ($movement_product->egress > 0) ? 'S' : 'I';
                $objMovement->codtienda   = $movement_product->store_id;
                $objMovement->codproducto = $movement_product->product_id;
                $objMovement->cantidad    = ($movement_product->egress > 0) ? $movement_product->egress : $movement_product->entry;
                array_push($arrMovements, $objMovement);
            }
        }

        return $arrMovements;
    }
}
