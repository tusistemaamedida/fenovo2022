<?php

namespace App\Http\Controllers\Admin;

use App\Exports\MovementsViewExport;
use App\Exports\ProductsViewExport;

use App\Http\Controllers\Controller;
use App\Models\ActualizacionPrecio;
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
        return view('admin.movimientos.print.print', compact('tiposalidas'));
    }

    public function printMovimientosPDF(Request $request)
    {
        $desde    = $request->desde;
        $hasta    = $request->hasta;
        $arrTypes = ($request->tipo) ? [$request->tipo] : ['COMPRA', 'VENTA', 'VENTACLIENTE', 'TRASLADO', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];

        $salidas = Movement::query()
            ->whereIn('type', $arrTypes)
            ->orderBy('created_at', 'ASC')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->desde, $request->hasta])
            ->get();

        $pdf = PDF::loadView('admin.movimientos.print.entreFechas', compact('salidas', 'desde', 'hasta'));
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

    public function printProductsPDF(Request $request)
    {
        $desde = $request->desde;
        $hasta = $request->hasta;

        if ($desde == '' or $hasta == '') {
            $actualizacion = ActualizacionPrecio::orderBy('fecha', 'desc')->skip(1)->first();
            $desde         = $actualizacion->fecha;

            $actualizacion = ActualizacionPrecio::orderBy('fecha', 'desc')->first();
            $hasta         = $actualizacion->fecha;
        }

        $productos = DB::table('products as t1')
            ->join('product_prices as t2', 't1.id', '=', 't2.product_id')
            ->select(
                't1.cod_fenovo',
                't1.cod_proveedor',
                't1.name',
                't2.plistproveedor',
                't2.descproveedor',
                't2.costfenovo',
                't2.mupfenovo',
                't2.plist0neto',
                't2.mup1',
                't2.p1may',
                't2.mupp1may',
                't2.p1tienda',
                't2.mupp1may',
                't2.cantmay1',
                't2.descp1',
                't2.tasiva',
                't1.barcode',
                't1.unit_package',
                't1.unit_type',
                't1.unit_weight',
                't2.mup2',
                't2.p2tienda',
                't1.package_palet',
                't1.package_row',
            )
            ->where('t1.active', 1)
            ->whereBetween(DB::raw('DATE(t2.updated_at)'), [$desde, $hasta])
            ->get();

        $pdf = PDF::loadView('admin.products.print.entreFechas', compact('productos', 'desde', 'hasta'));
        return $pdf->stream('novedades_productos.pdf');
    }

    public function exportProductsToCsv(Request $request)
    {
        return Excel::download(new ProductsViewExport($request), 'producto.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }
}
