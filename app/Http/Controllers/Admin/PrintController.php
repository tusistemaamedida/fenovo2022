<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsViewExport;

use App\Http\Controllers\Controller;
use App\Models\Exportaciones;
use App\Models\Movement;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;

use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;

class PrintController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;
    private $sessionProductRepository;

    use OriginDataTrait;

    public function __construct(
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        SessionProductRepository $sessionProductRepository,
        EnumRepository $enumRepository
    ) {
        $this->productRepository        = $productRepository;
        $this->customerRepository       = $customerRepository;
        $this->storeRepository          = $storeRepository;
        $this->sessionProductRepository = $sessionProductRepository;
        $this->enumRepository           = $enumRepository;
    }

    public function menuPrint(Request $request)
    {
        $tiposalidas = $this->enumRepository->getType('movimientos');
        $stores      = $this->storeRepository->getActives();
        return view('admin.print.print', compact('tiposalidas', 'stores'));
    }

    public function printMovimientosPDF(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        $arrTipos   = ['VENTA', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEntrada = ['VENTA', 'TRASLADO'];

        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry', 't2.egress', 't3.unit_type as unidad')
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
                    $objMovement->cantidad    = $movement->entry;
                    $objMovement->unidad      = $movement->unidad;
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
                $objMovement->cantidad    = ($movement->entry > 0) ? $movement->entry : $movement->egress;
                $objMovement->unidad      = $movement->unidad;
            }

            if ($creado) {
                array_push($arrMovements, $objMovement);
            }
        }

        $pdf = PDF::loadView('admin.print.movimientos.entreFechas', compact('arrMovements', 'desde', 'hasta'));
        return $pdf->stream('salidas_fechas.pdf');
    }

    public function exportMovimientosCsv(Request $request)
    {

        $exportacion = DB::table('movements')
            ->where('exported', '!=', 0)
            ->select('exported')
            ->orderBy('exported', 'DESC')
            ->pluck('exported')
            ->first();
        $numeracion = ($exportacion) ? $exportacion + 1 : 1;

        $arrTipos   = ['VENTA', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEntrada = ['VENTA', 'TRASLADO'];

        $movimientos = DB::table('movements as t1')
            ->join('movement_products as t2', 't1.id', '=', 't2.movement_id')
            ->join('products as t3', 't2.product_id', '=', 't3.id')
            ->join('stores as t4', 't2.entidad_id', '=', 't4.id')
            ->select('t1.id', 't1.type', 't1.date', 't1.from', 't4.cod_fenovo as cod_tienda', 't3.cod_fenovo as cod_producto', 't2.bultos', 't2.entry', 't2.egress', 't3.unit_type as unidad')
            ->whereIn('t1.type', $arrTipos)
            ->where('t2.entidad_tipo', '!=', 'C')
            ->where('t1.exported', '=', 0)
            ->orderBy('t1.date')
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
                    $objMovement->id          = 'R' . str_pad($numeracion, 8, '0', STR_PAD_LEFT);
                    $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                    $objMovement->tipo        = 'E';
                    $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                    $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                    $objMovement->cantidad    = $movement->entry;
                    $objMovement->unidad      = $movement->unidad;
                }
            } else {
                // Analizar las devoluciones
                $tipo                     = ($movement->entry > 0) ? 'E' : 'S';
                $objMovement              = new stdClass();
                $creado                   = true;
                $objMovement->origen      = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->id          = 'R' . str_pad($numeracion, 8, '0', STR_PAD_LEFT);
                $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
                $objMovement->tipo        = $tipo;
                $objMovement->codtienda   = str_pad($movement->cod_tienda, 3, '0', STR_PAD_LEFT);
                $objMovement->codproducto = str_pad($movement->cod_producto, 4, '0', STR_PAD_LEFT);
                $objMovement->cantidad    = ($movement->entry > 0) ? $movement->entry : $movement->egress;
                $objMovement->unidad      = $movement->unidad;
            }

            if ($creado) {
                array_push($arrMovements, $objMovement);

                $movimiento = Movement::find($movement->id);

                $numeracion++;
            }
        }

        return $arrMovements;

        //return Excel::download(new MovementsViewExport($request), 'movi.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }
}
