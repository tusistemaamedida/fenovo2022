<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsViewExport;

use App\Http\Controllers\Controller;
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
        $desde    = $request->desde;
        $hasta    = $request->hasta;
        $arrTypes = ($request->tipo) ? [$request->tipo] : ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];

        $salidas = Movement::query()
            ->whereIn('type', $arrTypes)
            ->orderBy('date', 'ASC')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->desde, $request->hasta])
            ->get();

        $pdf = PDF::loadView('admin.print.movimientos.entreFechas', compact('salidas', 'desde', 'hasta'));
        return $pdf->stream('salidas_fechas.pdf');
    }

    public function exportMovimientosCsv(Request $request)
    {
        // Sector de pruebas
        //
        // $arrTypes  = ($request->tipo) ? [$request->tipo] : ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE', 'VENTA', 'VENTACLIENTE', 'TRASLADO'];
        // $movements = Movement::whereIn('type', $arrTypes)
        //     ->whereBetween(DB::raw('DATE(date)'), [$request->desde, $request->hasta])
        //     ->orderBy('id', 'ASC')->get();

        // $arrMovements = [];
        // foreach ($movements as $movement) {
        //     foreach ($movement->movement_products as $movement_product) {
        //         if (!($movement_product->entidad_tipo == 'C')) {
        //             $objMovement              = new stdClass();
        //             $objMovement->id          = $movement_product->id;
        //             $objMovement->fecha       = date('d-m-Y', strtotime($movement->date));
        //             $objMovement->tipo        = ($movement_product->egress > 0) ? 'S' : 'E';
        //             $objMovement->codtienda   = DB::table('stores')->where('id', $movement_product->entidad_id)->select('cod_fenovo')->pluck('cod_fenovo')->first();
        //             $objMovement->codproducto = $movement_product->product->cod_fenovo;
        //             $objMovement->cantidad    = ($movement_product->egress > 0) ? $movement_product->egress : $movement_product->entry;
        //             array_push($arrMovements, $objMovement);
        //         }
        //     }
        // }
        // return $arrMovements;
        //
        //

        return Excel::download(new MovementsViewExport($request), 'movi.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }
}
