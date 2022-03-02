<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsExport;
use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SessionProductRepository;

use App\Repositories\StoreRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PrintController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;
    private $sessionProductRepository;

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
        return view('admin.movimientos.print.print', compact('tiposalidas'));
    }

    public function printEntreFechas(Request $request)
    {
        $desde    = $request->desde;
        $hasta    = $request->hasta;
        $arrTypes = ($request->tipo) ? [$request->tipo] : ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];

        $salidas = Movement::query()
            ->whereIn('type', $arrTypes)
            ->orderBy('created_at', 'ASC')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->desde, $request->hasta])
            ->get()
            ->unique('voucher_number');

        $pdf = PDF::loadView('admin.movimientos.print.entreFechas', compact('salidas', 'desde', 'hasta'));
        return $pdf->stream('salidas_fechas.pdf');
    }

    public function exportEntreFechas(Request $request)
    {
        return Excel::download(new MovementsExport($request), 'movement.csv');
    }
}
