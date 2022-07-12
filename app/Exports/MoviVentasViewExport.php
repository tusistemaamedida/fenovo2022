<?php

namespace App\Exports;

use App\Models\Movement;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class MoviVentasViewExport implements FromView
{
    protected $request;

    use Exportable;

    public function __construct(string $mes, string $anio)
    {
        $this->mes  = $mes;
        $this->anio = $anio;
    }

    public function view(): View
    {
        $mes  = $this->mes;
        $anio = $this->anio;

        $arrTipos = ['VENTA', 'VENTACLIENTE'];

        $arrMovimientos = [];

        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->leftJoin('invoices as t5', 't5.movement_id', '=', 't1.id')
            ->select(
                't1.id',
                't1.type',
                't1.date',
                't5.voucher_number',
                't3.cod_fenovo',
                't3.name',
                't3.unit_type',
                't2.unit_price as precio_venta',
                't2.cost_fenovo as precio_costo',
                't2.egress as cantidad',
                't2.tasiva as iva',
            )
            ->whereIn('t1.type', $arrTipos)
            ->whereMonth('t1.created_at', '=', $mes)
            ->whereYear('t1.created_at', '=', $anio)
            ->where('t2.egress', '>', 0)
            ->orderBy('t1.date')->orderBy('t1.id')->orderBy('t3.cod_fenovo')
            ->get();

        foreach ($movimientos as $movimiento) {
            $movement = Movement::find($movimiento->id);
            $destino  = $movement->origenData($movement->type);

            $objMovimiento = new stdClass();

            $objMovimiento->id           = str_pad($movimiento->id, 8, '0', STR_PAD_LEFT);
            $objMovimiento->type         = $movimiento->type;
            $objMovimiento->destino      = $destino;
            $objMovimiento->fecha        = date('d/m/Y', strtotime($movimiento->date));
            $objMovimiento->factura      = $movimiento->voucher_number;
            $objMovimiento->cod_fenovo   = $movimiento->cod_fenovo;
            $objMovimiento->producto     = $movimiento->name;
            $objMovimiento->unidad       = $movimiento->unit_type;
            $objMovimiento->iva          = $movimiento->iva;
            $objMovimiento->precio_venta = $movimiento->precio_venta;
            $objMovimiento->importeiva   = $this->getImporteIva($movimiento->precio_costo, $movimiento->iva, $movimiento->voucher_number);
            $objMovimiento->importeBruto = $this->getImporteBruto($movimiento->precio_costo, $objMovimiento->importeiva);
            $objMovimiento->cantidad     = $movimiento->cantidad;
            $objMovimiento->precio_costo = $movimiento->precio_costo;
            $objMovimiento->venta_total  = $this->getVentaTotal($objMovimiento->precio_venta, $movimiento->cantidad);
            $objMovimiento->costo_total  = $this->getCostoTotal($movimiento->precio_costo, $movimiento->cantidad);
            $objMovimiento->utilidad_total  = json_decode($objMovimiento->venta_total)-json_decode($objMovimiento->costo_total);

            array_push($arrMovimientos, $objMovimiento);
        }

        return view('exports.moviVentas', compact('arrMovimientos'));
    }

    private function getImporteIva($importe, $iva, $voucher)
    {
        if (strlen($voucher) == 0) {
            $iva = '0.0';
        } else {
            $iva = ($importe * json_decode($iva)) / 100;
        }
        return round($iva, 2);
    }

    private function getImporteBruto($importe, $iva)
    {
        return json_decode($importe) + json_decode($iva);
    }

    private function getCostoTotal($importe, $cantidad)
    {
        return json_decode($importe) * json_decode($cantidad);
    }

    private function getVentaTotal($importe, $cantidad)
    {
        return json_decode($importe) * json_decode($cantidad);
    }
}
