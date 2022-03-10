<?php

namespace App\Exports;

use App\Models\Movement;
use App\Models\Store;
use App\Traits\OriginDataTrait;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use stdClass;

class MovementsExport implements FromArray
{
    use Exportable, SerializesModels;
    use OriginDataTrait;

    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function array():array
    {
        $arrTypes  = ($this->request->tipo) ? [$this->request->tipo] : ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movements = Movement::whereIn('type', $arrTypes)
            ->whereBetween(DB::raw('DATE(date)'), [$this->request->desde, $this->request->hasta])
            ->orderBy('id', 'ASC')->get();

        $arrMovements = [];

        foreach ($movements as $movement) {
            foreach ($movement->movement_products as $movement_product) {
                // NO INFORMO CLIENTE DONDE VAN LAS VENTAS
                if (!($movement->type == 'VENTACLIENTE' && $movement_product->entidad_tipo == 'C')) {
                    // NO INFORMO CLIENTE QUE DEVUELVE
                    if (!($movement->type == 'DEVOLUCION' && $movement_product->entidad_tipo == 'C')) {
                        if ($movement->type == 'VENTACLIENTE') {
                            $tienda     = $movement->From($movement->type, true);
                            $cod_tienda = $tienda->cod_fenovo;
                        } else {
                            if ($movement->type !== 'DEVOLUCION') {
                                $tienda = ($movement_product->egress > 0) ? $movement->From($movement->type, true) : $movement->To($movement->type, true);
                            } else {
                                $tienda = ($movement_product->egress > 0) ? $movement->To($movement->type, true) : $movement->From($movement->type, true);
                            }
                            $cod_tienda = $tienda->cod_fenovo;
                        }

                        $objMovement = new stdClass();

                        $objMovement->id          = $movement_product->id;
                        $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                        $objMovement->tipo        = ($movement_product->egress > 0) ? 'S' : 'E';
                        $objMovement->codtienda   = $cod_tienda;
                        $objMovement->codproducto = $movement_product->product->cod_fenovo;
                        $objMovement->cantidad    = ($movement_product->egress > 0) ? $movement_product->egress : $movement_product->entry;

                        array_push($arrMovements, $objMovement);
                    }
                }
            }
        }

        return $arrMovements;
    }
}
