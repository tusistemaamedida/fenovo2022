<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Exports\OrdenConsolidadaViewExport;
use App\Http\Controllers\Controller;

use App\Models\Customer;
use App\Models\FleteSetting;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\OfertaStore;
use App\Models\Panamas;
use App\Models\Product;
use App\Models\ProductStore;
use App\Models\SessionOferta;
use App\Models\SessionProduct;
use App\Models\Store;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;
use App\Traits\OriginDataTrait;
use App\Models\Invoice;

use App\Models\Pedido;
use App\Models\PedidoProductos;
use App\Models\PedidoEstados;

use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use PDFMerger;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class SalidasController extends Controller
{
    use OriginDataTrait;

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

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
            $movement = Movement::whereIn('type', $arrTypes)->orderBy('date','DESC')->orderBy('id','DESC')->limit(400)->get();

            return DataTables::of($movement)
                ->addColumn('id', function ($movement) {
                    return '<a title="Detalles de salida" href="' . route('salidas.show', ['id' => $movement->id]) . '">' . str_pad($movement->id, 6, '0', STR_PAD_LEFT) . '</a>';
                })
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    $count = MovementProduct::whereMovementId($movement->id)->where('egress', '>', 0)->distinct('product_id')->count();
                    return '<span class="badge badge-primary">' . $count . '</span>';
                })
                ->editColumn('type', function ($movement) {
                    return $movement->type;
                })
                ->editColumn('factura_nro', function ($movement) {
                    if ($movement->type == 'VENTA' || $movement->type == 'VENTACLIENTE') {
                        if ($movement->invoice && !is_null($movement->invoice->cae)) {
                            return '<a class="text-primary" title="Descargar factura" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> ' . $movement->invoice->voucher_number . ' </a>';
                        }
                        return ($movement->verifSiFactura()) ? '<a href="' . route('create.invoice', ['movment_id' => $movement->id]) . '">Generar Factura </a>' : '';
                    }
                })
                ->editColumn('updated_at', function ($movement) {
                    return date('Y-m-d H:i:s', strtotime($movement->updated_at));
                })
                ->addColumn('remito', function ($movement) {
                    return '<a title="Imprimir remito"  href="javascript:void(0)" onclick="createRemito(' . $movement->id . ')"> <i class="fas fa-print"></i> </a>';
                })
                ->addColumn('paper', function ($movement) {
                    if ($movement->hasPanama()) {
                        $orden = $movement->getPanama()->orden;
                        return '<a class="text-primary" title="Imprime panama"  href="' . route('print.panama', ['id' => $movement->id]) . '" target="_blank">' . $orden . '</a>';
                    }
                })
                ->addColumn('flete', function ($movement) {
                    if ($movement->hasFlete()) {
                        $orden = $movement->getFlete()->orden;
                        return '<a class="text-primary" title="Imprimir flete' . $orden . '"  href="' . route('print.panama.felete', ['id' => $movement->id]) . '" target="_blank">' . $orden . '</a>';
                    }
                })
                ->addColumn('orden', function ($movement) {
                    return ($movement->hasInvoices())
                        ? '<a class="text-primary" title="Imprimir Orden"  href="' . route('print.orden', ['id' => $movement->id]) . '" target="_blank"> <i class="fas fa-list"></i> </a>'
                        : null;
                })
                ->addColumn('ordenpanama', function ($movement) {
                    return ($movement->hasPanama())
                        ? '<a title="Imprimir Orden panama"  href="' . route('print.ordenPanama', ['id' => $movement->id]) . '" target="_blank"> <i class="fas fa-list"></i> </a>'
                        : null;
                })

                ->rawColumns(['id', 'origen', 'items', 'date', 'type', 'factura_nro', 'remito', 'paper', 'flete', 'orden', 'ordenpanama'])
                ->make(true);
        }
        return view('admin.movimientos.salidas.index');
    }

    public function pendientes(Request $request)
    {
        if ($request->ajax()) {
            $pendientes = $this->sessionProductRepository->groupBy('list_id');
            return DataTables::of($pendientes)
                ->addIndexColumn()
                ->addColumn('actualizacion', function ($pendiente) {
                    return date('d-m-Y H:i:s', strtotime($pendiente->updated_at));
                })
                ->addColumn('destino', function ($pendiente) {
                    $explode = explode('_', $pendiente->list_id);
                    return $this->origenDataCiudad($explode[0], $explode[1]);
                })
                ->addColumn('items', function ($pendiente) {
                    return '<span class="badge badge-primary">' . $pendiente->total . '</span>';
                })
                ->addColumn('destroy', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        $ruta = "borrarPendiente('" . $pendiente->list_id . "','" . route('salidas.pendiente.destroy') . "')";
                        return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                    }else{
                        return '';
                    }
                })
                ->addColumn('pausar', function ($pendiente) {
                    $pausado = (!is_null($pendiente->pausado))? '<label style="color:red;font-size:9px">Pausado</label>':'';
                    $action = "pausarSalida('".$pendiente->list_id."','".$pendiente->pausado."')";
                    return '<a href="javascript:void(0)" onclick="' . $action . '" > <i class="fa fa-retweet" aria-hidden="true"></i> '.$pausado.' </a>';
                })
                ->addColumn('edit', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        return '<a href="' . route('salidas.pendiente.show', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-pencil-alt"></i> </a>';
                    }else{
                        return '';
                    }
                })
                ->addColumn('print', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        return '<a target="_blank" href="' . route('salidas.pendiente.print', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-print"></i> </a>';
                    }else{
                        return '';
                    }
                })
                ->rawColumns(['actualizacion', 'items', 'destino', 'edit', 'destroy', 'print','pausar'])
                ->make(true);
        }
        return view('admin.movimientos.salidas.pendientes');
    }

    public function pendienteShow(Request $request)
    {
        $explode     = explode('_', $request->input('list_id'));
        $pedido = null;
        if(count($explode)==3){
            $pedido = $explode[2];
        }
        $tipo        = $explode[0];
        $destino     = $this->origenData($tipo, $explode[1], true);
        $destinoName = $this->origenData($tipo, $explode[1]);
        return view('admin.movimientos.salidas.add', compact('tipo', 'destino', 'destinoName','pedido'));
    }

    public function getTotalMovement(Request $request)
    {
        $total    = 0;
        $movement = Movement::query()->where('id', $request->input('movement_id'))->with('movement_salida_products')->first();
        $products = $movement->movement_salida_products;
        foreach ($products as $product) {
            if ($product->invoice) {
                $subtotal = $product->bultos * $product->unit_price * $product->unit_package;
                $total += $subtotal;
            }
        }

        return new JsonResponse(['type' => 'success', 'total' => number_format($total, 2, ',', '.')]);
    }

    public function pendientePrint(Request $request)
    {
        //Cod:: salpend001

        $session_products = DB::table('session_products as t1')
            ->join('products as t2', 't1.product_id', '=', 't2.id')
            ->select('t1.id', 't2.cod_fenovo', 't2.name', 't2.cod_proveedor', 't1.quantity', 't2.unit_weight', 't1.unit_package', 't2.unit_type')
            ->where('t1.list_id', '=', $request->list_id)
            ->orderBy('t2.cod_fenovo')
            ->get();

        $explode = explode('_', $request->input('list_id'));

        $tipo    = $explode[0];
        $destino = $this->origenData($tipo, $explode[1], true);
        $pdf     = PDF::loadView('print.pendientes', compact('session_products', 'destino'));
        return $pdf->stream('salidas.pdf');
    }

    public function printOrden(Request $request)
    {
        $orden    = $request->id;
        $movement = Movement::with(['movement_salida_products'])->whereId($orden)->first();

        if ($movement) {
            if ($movement->type == 'TRASLADO') {
                $store = Store::find($movement->to);
                if (isset($store) && ($store->store_type == 'B')) {
                    $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
                }
            }
            $destino         = $this->origenData($movement->type, $movement->to, true);
            $array_productos = [];
            $movimientos     = $movement->movement_salida_products;
            foreach ($movimientos as $movimiento) {
                if ($movimiento->invoice) {
                    $objProduct               = new stdClass();
                    $objProduct->cod_fenovo   = $movimiento->product->cod_fenovo;
                    $objProduct->name         = $movimiento->product->name;
                    $objProduct->unit_weight  = $movimiento->product->unit_weight;
                    $objProduct->unit_type    = $movimiento->unit_type;
                    $objProduct->unit_package = $movimiento->unit_package;
                    $objProduct->quantity     = $movimiento->bultos;
                    $objProduct->unity        = '( ' . $movimiento->unit_package . ' ' . $movimiento->product->unit_type . ' )';
                    $objProduct->total_unit   = number_format($movimiento->bultos * $movimiento->unit_package, 2, ',', '.');
                    $objProduct->class        = '';
                    array_push($array_productos, $objProduct);
                }
            }

            $pdf = PDF::loadView('print.orden', compact('orden', 'destino', 'array_productos'));
            return $pdf->stream('orden-' . $request->id . '.pdf');
        }
    }

    public function printOrdenPanama(Request $request)
    {
        $orden    = $request->id;
        $movement = Movement::with(['panamas'])->whereId($orden)->first();

        if ($movement) {
            if ($movement->type == 'TRASLADO') {
                $store = Store::find($movement->to);
                if (isset($store) && ($store->store_type == 'B')) {
                    $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
                }
            }
            $destino         = $this->origenData($movement->type, $movement->to, true);
            $array_productos = [];
            $productos       = $movement->panamas;
            foreach ($productos as $producto) {
                $objProduct               = new stdClass();
                $objProduct->cod_fenovo   = $producto->product->cod_fenovo;
                $objProduct->name         = $producto->product->name;
                $objProduct->unit_weight  = $producto->product->unit_weight;
                $objProduct->unit_package = $producto->unit_package;
                $objProduct->quantity     = $producto->bultos;
                $objProduct->unity        = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                $objProduct->total_unit   = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->class        = '';
                array_push($array_productos, $objProduct);
            }

            $pdf = PDF::loadView('print.ordenPanama', compact('orden', 'destino', 'array_productos'));
            return $pdf->stream('orden-' . $request->id . '.pdf');
        }
    }

    public function printOrdenes(Request $request)
    {
        // Orden
        $orden    = $request->id;
        $movement = Movement::with(['movement_salida_products'])->whereId($orden)->first();

        if ($movement->type == 'TRASLADO') {
            $store = Store::find($movement->to);
            if (isset($store) && ($store->store_type == 'B')) {
                $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
            }
        }
        $destino         = $this->origenData($movement->type, $movement->to, true);
        $array_productos = [];
        $productos       = $movement->movement_salida_products;
        foreach ($productos as $producto) {
            if ($producto->invoice) {
                $objProduct               = new stdClass();
                $objProduct->cod_fenovo   = $producto->product->cod_fenovo;
                $objProduct->name         = $producto->product->name;
                $objProduct->unit_weight  = $producto->product->unit_weight;
                $objProduct->unit_package = $producto->unit_package;
                $objProduct->quantity     = $producto->bultos;
                $objProduct->unity        = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                $objProduct->total_unit   = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->class        = '';
                array_push($array_productos, $objProduct);
            }
        }

        // Guarda el PDF en la carpeta public

        $orden = 'orden-' . $request->id . '.pdf';
        $pdf   = PDF::loadView('print.orden', compact('orden', 'destino', 'array_productos'));
        $pdf->save($orden);

        if ($movement->type == 'TRASLADO') {
            $store = Store::find($movement->to);
            if (isset($store) && ($store->store_type == 'B')) {
                $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
            }
        }
        $destino         = $this->origenData($movement->type, $movement->to, true);
        $array_productos = [];
        $productos       = $movement->panamas;
        foreach ($productos as $producto) {
            $objProduct               = new stdClass();
            $objProduct->cod_fenovo   = $producto->product->cod_fenovo;
            $objProduct->name         = $producto->product->name;
            $objProduct->unit_weight  = $producto->product->unit_weight;
            $objProduct->unit_package = $producto->unit_package;
            $objProduct->quantity     = $producto->bultos;
            $objProduct->unity        = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
            $objProduct->total_unit   = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
            $objProduct->class        = '';
            array_push($array_productos, $objProduct);
        }

        $ordenp = 'ordenp-' . $request->id . '.pdf';
        $pdfp   = PDF::loadView('print.ordenPanama', compact('orden', 'destino', 'array_productos'));
        $pdf->save($ordenp);

        $pdfMerger = PDFMerger::init();
        $pdfMerger->addPDF($orden, 'all');
        $pdfMerger->addPDF($ordenp, 'all');
        $pdfMerger->merge();
        $pdfMerger->setFileName('ordenes-' . $request->id . '.pdf');
        $pdfMerger->download();
    }

    public function indexOrdenConsolidada(Request $request)
    {

        if ($request->ajax()) {

            $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
            $movement = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('id');

            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('destino_id', function ($movement) {
                    $destino = Movement::find($movement->id)->To($movement->type, true);
                    return ($destino->cod_fenovo) ? $destino->cod_fenovo : $destino->id;
                })
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('Y-m-d', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    $count = count(MovementProduct::whereMovementId($movement->id)->where('egress', '>', 0)->get());
                    return '<span class="badge badge-primary">' . $count . '</span>';
                })
                ->editColumn('type', function ($movement) {
                    return $movement->type;
                })
                ->addColumn('kgrs', function ($movement) {
                    return $movement->totalKgrs();
                })
                ->addColumn('bultos', function ($movement) {
                    return  MovementProduct::whereMovementId($movement->id)->where('egress', '>', 0)->sum('bultos');
                })
                ->addColumn('flete', function ($movement) {
                    return  ($movement->hasFlete()) ? $movement->getFlete()->neto105 + $movement->getFlete()->neto21 : '0.0';
                })
                ->addColumn('neto', function ($movement) {
                    return  ($movement->invoice) ? $movement->invoice->sum('imp_neto') : '0.0';
                })
                ->addColumn('panama1', function ($movement) {
                    return  ($movement->hasFlete()) ? $movement->getFlete()->id : '0.0';
                })
                ->addColumn('panama2', function ($movement) {
                    return  '0.0';
                })

                ->rawColumns(['destino_id', 'destino', 'date', 'items', 'type', 'kgrs', 'bultos', 'flete', 'neto', 'panama1', 'panama2'])

                ->make(true);
        }
        return view('admin.movimientos.salidas.consolidada');
    }

    public function printOrdenConsolidada(Request $request)
    {
        return Excel::download(new OrdenConsolidadaViewExport(), 'ordenes.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function printPanamaFlete(Request $request)
    {
        $panama   = Panamas::where('movement_id', $request->id)->where('tipo', '!=', 'PAN')->first();
        $movement = Movement::query()->where('id', $request->id)->where('flete_invoice', false)->first();

        if (isset($panama)) {
            $orden = $panama->orden;
        } else {
            $orden = $movement->orden;
        }

        if ($movement) {
            $id_flete               = '8889-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
            $destino                = $this->origenData($movement->type, $movement->to, true);
            $fecha                  = \Carbon\Carbon::parse($panama->created_at)->format('d/m/Y');
            $neto                   = 0;
            $array_productos        = [];
            $objProduct             = new stdClass();
            $objProduct->cant       = 1;
            $objProduct->name       = 'FLETE';
            $objProduct->unit_price = number_format($movement->flete, 2, ',', '.');
            $objProduct->subtotal   = $neto   = number_format($movement->flete, 2, ',', '.');
            $objProduct->class      = '';
            array_push($array_productos, $objProduct);
            $pdf = PDF::loadView('print.panamaFelete', compact('destino', 'array_productos', 'neto', 'id_flete', 'fecha'));
            return $pdf->stream($id_flete . '.pdf');
        }
    }

    public function printRemito(Request $request)
    {
        $movement = Movement::query()->where('id', $request->input('movement_id'))->with('movement_salida_products')->first();
        if ($movement) {
            // Ver si es un traslado a base
            $mercaderia_en_transito = null;
            if ($movement->type == 'TRASLADO') {
                $store = Store::find($movement->to);
                if (isset($store) && ($store->store_type == 'B')) {
                    $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
                }
            }
            $id_remito       = 'R' . str_pad($movement->id, 8, '0', STR_PAD_LEFT);
            $destino         = $this->origenData($movement->type, $movement->to, true);
            $fecha           = \Carbon\Carbon::parse($movement->created_at)->format('d/m/Y');
            $neto            = $request->input('neto');
            $array_productos = [];
            $productos       = $movement->movement_salida_products;
            foreach ($productos as $producto) {
                if ($producto->invoice) {
                    $objProduct             = new stdClass();
                    $objProduct->cant       = $producto->bultos;
                    $objProduct->codigo     = $producto->product->cod_fenovo;
                    $objProduct->name       = $producto->product->name;
                    $objProduct->unity      = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                    $objProduct->total_unit = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                    $objProduct->class      = '';
                    array_push($array_productos, $objProduct);
                }
            }

            $pdf = PDF::loadView('print.remito', compact('destino', 'fecha', 'array_productos', 'neto', 'mercaderia_en_transito'));
            return $pdf->stream('remito.pdf');
        }
    }

    public function printPanama(Request $request)
    {
        $panama   = Panamas::where('movement_id', $request->id)->where('tipo', 'PAN')->first();
        $movement = Movement::query()->where('id', $request->id)->with('panamas')->first();
        if (isset($panama)) {
            $orden = $panama->orden;
        } else {
            $orden = $movement->orden;
        }
        if ($movement) {
            $id_panama       = '8889-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
            $destino         = $this->origenData($movement->type, $movement->to, false);
            $fecha           = \Carbon\Carbon::parse($panama->created_at)->format('d/m/Y');
            $neto            = 0;
            $array_productos = [];
            $productos       = $movement->panamas;
            foreach ($productos as $producto) {
                $subtotal               = $producto->bultos * $producto->unit_price * $producto->unit_package;
                $objProduct             = new stdClass();
                $objProduct->cant       = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->bultos     = $producto->bultos;
                $objProduct->unidad     = $producto->product->unit_type;
                $objProduct->cod_fenovo = $producto->product->cod_fenovo;
                $objProduct->codigo     = $producto->product->cod_fenovo;
                $objProduct->name       = $producto->product->name;
                $objProduct->unit_price = number_format($producto->unit_price, 2, ',', '.');
                $objProduct->subtotal   = number_format($subtotal, 2, ',', '.');
                $objProduct->unity      = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                $objProduct->total_unit = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->class      = '';
                $neto += $subtotal;
                array_push($array_productos, $objProduct);
            }

            $pdf = PDF::loadView('print.panama', compact('destino', 'array_productos', 'neto', 'id_panama', 'fecha'));
            return $pdf->stream($id_panama . '.pdf');
        }
    }

    public function add()
    {
        $this->sessionProductRepository->deleteDevoluciones();
        return view('admin.movimientos.salidas.add');
    }

    public function show(Request $request)
    {
        $movement = Movement::query()->where('id', $request->id)->with('movement_salida_products')->first();
        $store    = Store::find($movement->to);
        return view('admin.movimientos.salidas.show', compact('movement', 'store'));
    }

    public function getClienteSalida(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];

        $this->sessionProductRepository->deleteDevoluciones();
        $this->sessionProductRepository->deleteDebitos();

        if ($request->to_type == 'VENTACLIENTE' || $request->to_type == 'DEVOLUCIONCLIENTE' || $request->to_type == 'DEBITOCLIENTE') {
            $customers = $this->customerRepository->search($term);
            foreach ($customers as $customer) {
                $valid_names[] = ['id' => $customer->id, 'text' => $customer->displayName()];
            }
        } else {
            $stores = $this->storeRepository->search($term);
            foreach ($stores as $store) {
                $valid_names[] = ['id' => $store->id, 'text' => $store->displayName()];
            }
        }

        return new JsonResponse($valid_names);
    }

    public function searchProducts(Request $request)
    {
        $term        = $request->term ?: '';
        $show_stock  = $request->has('show_stock') ? (bool)$request->show_stock : true;
        $valid_names = [];
        $products    = $this->productRepository->search($term);

        foreach ($products as $product) {
            $disabled      = '';
            $text_no_stock = '';

            if ($show_stock) {
                $stock = $product->stock(null, Auth::user()->store_active);
                if (!$stock) {
                    // $disabled      = 'disabled';
                    $text_no_stock = ' -- SIN STOCK --';
                }
            }

            $valid_names[] = [
                'id'       => $product->id,
                'text'     => $product->name . '' . $text_no_stock,
                'disabled' => $disabled,  ];
        }

        return  new JsonResponse($valid_names);
    }

    public function buscarProductos(Request $request)
    {
        $producto    = Product::whereCodFenovo($request->term)->first();
        $arrProducto = [];
        if ($producto) {
            $oferta = SessionOferta::doesntHave('stores')->whereProductId($producto->id)->first();
            $ruta   = ($oferta)
            ? route('product.edit', ['id' => $producto->id, 'oferta_id' => $oferta->id, 'fecha_oferta' => $oferta->id]) . '#precios'
            : route('product.edit', ['id' => $producto->id]);

            $dir           = '<a title="editar" href="' . $ruta . '"><i class="fa fa-edit"></i></a>';
            $arrProducto[] = [
                'id'   => $producto->id,
                'text' => $producto->name,
                'dir'  => $dir,
            ];

            return  new JsonResponse($arrProducto);
        }
    }

    public function getSessionProducts(Request $request)
    {
        try {
            $session_products      = $this->sessionProductRepository->getByListId($request->input('list_id'));
            $mostrar_check_invoice = !(str_contains($request->input('list_id'), 'DEVOLUCION_') || str_contains($request->input('list_id'), 'DEBITO_'));
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.salidas.partials.form-table-products', compact('session_products', 'mostrar_check_invoice'))->render(),
            ]);
        } catch (\Exception $e) {
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function getFleteSessionProducts(Request $request)
    {
        try {
            $total = $request->input('total_from_session');
            $km    = $this->sessionProductRepository->getFlete($request->input('list_id'));
            if ($km) {
                $fleteSetting = FleteSetting::where('hasta', '>=', $km)->orderBy('hasta', 'ASC')->first();
                $porcentaje   = $fleteSetting->porcentaje;
                $flete        = round((($porcentaje * $total) / 100), 2);
            } else {
                $flete      = 0;
                $porcentaje = 0;
            }
            return new JsonResponse([
                'flete'      => $flete,
                'porcentaje' => $porcentaje,
            ]);
        } catch (\Exception $e) {
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function deleteSessionProduct(Request $request)
    {
        try {
            $session_products = $this->sessionProductRepository->delete($request->input('id'));
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function getPresentaciones(Request $request)
    {
        try {
            if ($request->has('id') && $request->input('id') != '') {
                $product    = $this->productRepository->getById($request->input('id'));
                $list_id    = $request->input('list_id');
                $devolucion = str_contains($list_id, 'DEVOLUCION_');
                $debito     = str_contains($list_id, 'DEBITO_');

                if ($product) {
                    $stock_presentaciones = [];
                    $presentaciones       = explode('|', $product->unit_package);
                    $stock_total          = $product->stockReal(null, Auth::user()->store_active);
                    $stock_session        = $product->stockEnSession(null, Auth::user()->store_active);

                    for ($i = 0; $i < count($presentaciones); $i++) {
                        $bultos                                   = 0;
                        $bultos_en_session                        = 0;
                        $presentacion                             = ($presentaciones[$i] == 0) ? 1 : $presentaciones[$i];
                        $stock_en_session                         = $this->sessionProductRepository->getCantidadTotalDeBultos($product->id, $presentacion);
                        $stock                                    = $product->stock($presentacion);
                        $stock_presentaciones[$i]['presentacion'] = $presentacion;
                        $stock_presentaciones[$i]['unit_weight']  = $product->unit_weight;
                        // los bultos que hay disponibles se calcula dividiendo el balance por el peso del bulto
                        $peso_por_bulto = $product->unit_weight * $presentacion;

                        if ($stock) {
                            $bultos = $stock / $peso_por_bulto;
                        }
                        if ($stock_en_session) {
                            $bultos -= $stock_en_session;
                        }
                        $stock_presentaciones[$i]['bultos'] = (int)$bultos;
                    }

                    if ($devolucion) {
                        $view = 'admin.movimientos.notas-credito.partials.inserByAjax';
                    } elseif ($debito) {
                        $view = 'admin.movimientos.notas-debito.partials.inserByAjax';
                    } else {
                        $view = 'admin.movimientos.salidas.partials.inserByAjax';
                    }

                    return new JsonResponse([
                        'type' => 'success',
                        'html' => view(
                            $view,
                            compact('stock_presentaciones', 'product', 'presentaciones', 'stock_total', 'stock_session')
                        )->render(),
                    ]);
                }
                return  new JsonResponse(['msj' => 'El producto no existe', 'type' => 'error']);
            }
            return new JsonResponse(['msj' => 'Limpiando...', 'type' => 'clear']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeSessionProduct(Request $request)
    {
        try {
            $count_unidades_cero = 0;
            $to                  = $request->input('to');
            $to_type             = $request->input('to_type');
            $unidades            = $request->input('unidades');
            $product_id          = $request->input('product_id');
            $unit_type           = $request->input('unit_type');

            if (!$to || $to_type == '') {
                return new JsonResponse(['msj' => 'Ingrese el tipo de movimiento.', 'type' => 'error', 'index' => 'to_type']);
            }

            if (!$to) {
                return new JsonResponse(['msj' => 'Ingrese el cliente o tienda según corresponda.', 'type' => 'error', 'index' => 'to']);
            }
            if (!$unidades || count($unidades) == 0) {
                return new JsonResponse(['msj' => 'Ingrese una cantidad a enviar.', 'type' => 'error', 'index' => 'quantity']);
            }
            for ($i = 0; $i < count($unidades); $i++) {
                $unidad = $unidades[$i];
                if ($unidad['value'] == 0 || $unidad['value'] == '0') {
                    $count_unidades_cero++;
                }
            }
            if (count($unidades) == $count_unidades_cero) {
                return new JsonResponse(['msj' => 'Ingrese una cantidad a enviar.', 'type' => 'error', 'index' => 'quantity']);
            }
            $insert_data = [];
            $product     = $this->productRepository->getByIdWith($product_id);

            $excepcion = false;
            // busco el producto en session oferta ordenados asc para tomar el primero
            $session_oferta = SessionOferta::where('fecha_desde', '<=', Carbon::parse(now())->format('Y-m-d'))
                ->where('product_id', $product_id)
                ->orderBy('fecha_hasta', 'ASC')
                ->first();

            if ($session_oferta) {
                // si existe una oferta busco si esa oferta es una excepcion
                $ofertaStore = OfertaStore::where('session_id', $session_oferta->id)->first();

                if ($ofertaStore) {
                    // si la oferta esta en oferta_store es porque es una excepcion y solo se aplica a la store vinculada
                    $excepcion = true;
                    if ($ofertaStore->store_id == $to) {
                        // si la store a la que envio esta en la oferta_store aplica la oferta
                        $prices = $session_oferta;
                    } else {
                        // si la store a la que envio NO esta en la oferta_store NO s aplica la oferta
                        $prices = $product->product_price;
                    }
                } else {
                    // como existe la oferta y no esta en oferta_store (excepcion) los precios son de la oferta
                    $prices = $session_oferta;
                }
            } else {
                $prices = $product->product_price;
            }

            switch ($to_type) {
                case 'DEVOLUCION':
                case 'DEBITO':
                case 'VENTA':
                case 'TRASLADO':
                    //$ofertaStore = OfertaStore::where('store_id',$to)
                    $insert_data['unit_price'] = $prices->plist0neto;
                    $insert_data['tasiva']     = $prices->tasiva;
                    $insert_data['neto']       = $prices->plist0neto;
                    break;
                case 'DEVOLUCIONCLIENTE':
                case 'VENTACLIENTE':
                case 'DEBITOCLIENTE':
                    $customer       = $this->customerRepository->getById($to);
                    $listAssociates = [
                        'L0' => $prices->plist0neto,
                        'L1' => $prices->plist1,
                        'L2' => $prices->plist2,
                    ];
                    $insert_data['unit_price'] = $listAssociates[$customer->listprice_associate];
                    $insert_data['tasiva']     = $prices->tasiva;
                    $insert_data['neto']       = $insert_data['unit_price'] / (1 + ($prices->tasiva / 100)); //Este valor se toma cuando no se factura
                    break;
            }

            $insert_data['unit_type']    = $unit_type;
            $insert_data['costo_fenovo'] = $prices->costfenovo;
            $insert_data['list_id']      = $to_type . '_' . $to;
            $insert_data['store_id']     = Auth::user()->store_active;
            $insert_data['invoice']      = true;
            $insert_data['iibb']         = $product->iibb;
            $insert_data['product_id']   = $product_id;

            $SR   = (!is_null($product->stock_r))?$product->stock_r:0;
            $SF   = (!is_null($product->stock_f))?$product->stock_f:0;
            $SCYO = (!is_null($product->stock_cyo))?$product->stock_cyo:0;
            $ST   = $SF + $SR;
            $coef_f = ($ST > 0)?(int) round(($SF * 100) / $ST):0;

            for ($i = 0; $i < count($unidades); $i++) {
                $unidad   = $unidades[$i];
                $quantity = (float)$unidad['value'];
                $qty_f = $qty_r = $qty_cyo = $diff = 0;

                if ($quantity > 0) {
                    $explode                     = explode('_', $unidad['name']);
                    $insert_data['unit_package'] = $explode[1];

                    $cant_total = ($unit_type == 'K') ? ($product->unit_weight * $insert_data['unit_package'] * $quantity) : ($insert_data['unit_package']  * $quantity);

                    $stock_en_session_f   = $this->sessionProductRepository->getCantidadTotalDeBultosByListId($product_id, $insert_data['unit_package'], $insert_data['list_id'],'F');
                    $stock_en_session_r   = $this->sessionProductRepository->getCantidadTotalDeBultosByListId($product_id, $insert_data['unit_package'], $insert_data['list_id'],'R');
                    $stock_en_session_cyo = $this->sessionProductRepository->getCantidadTotalDeBultosByListId($product_id, $insert_data['unit_package'], $insert_data['list_id'],'CyO');

                    // Primero debo buscar el stock en F Y R Luego buscar en CYO si ninguno de los tres llega a cubrir la cantidad solicitada
                    // pero hay algo en stock debo tomar lo que hay
                    $total_r   = ($unit_type == 'K') ? ($SR   / ($product->unit_weight * $insert_data['unit_package'])) : ($SR  / $insert_data['unit_package']);
                    $total_cyo = ($unit_type == 'K') ? ($SCYO / ($product->unit_weight * $insert_data['unit_package'])) : ($SCYO/ $insert_data['unit_package']);
                    $total_f   = ($unit_type == 'K') ? ($SF   / ($product->unit_weight * $insert_data['unit_package'])) : ($SF  / $insert_data['unit_package']);

                    if($cant_total <= $ST){
                        $qty_f = round((($coef_f * $quantity) / 100),0,PHP_ROUND_HALF_UP);
                        $qty_r = $quantity - $qty_f;
                    }elseif($cant_total <= ($ST + $SCYO)){
                        $qty_f   = $total_f;
                        $qty_r   = $total_r;
                        $qty_cyo = (int)($quantity - $qty_f - $qty_r);
                    }elseif(($ST + $SCYO) > 0){
                        $qty_r   = $total_r;
                        $qty_cyo = $total_cyo;
                        $qty_f   = $total_f;
                        $diff    = $quantity - $qty_r - $qty_cyo - $qty_f;
                        $qty_f  += $diff ;
                    }elseif(($ST + $SCYO) == 0){
                        $qty_f   = $quantity ;
                    }
                    // Inserta session product en F
                    $insert_data['circuito']     = 'F';
                    $insert_data['quantity']     = $qty_f + $stock_en_session_f;
                    if($insert_data['quantity'] > 0) $this->sessionProductRepository->updateOrCreate($insert_data);

                    // Inserta session product en R
                    $insert_data['circuito']     = 'R';
                    $insert_data['invoice']      = 0;
                    $insert_data['quantity']     = $qty_r + $stock_en_session_r;
                    if($insert_data['quantity'] > 0) $this->sessionProductRepository->updateOrCreate($insert_data);

                    // Inserta session product en CyO
                    $insert_data['circuito']     = 'CyO';
                    $insert_data['invoice']      = 1;
                    $insert_data['quantity']     = $qty_cyo + $stock_en_session_cyo;
                    if($insert_data['quantity'] > 0) $this->sessionProductRepository->updateOrCreate($insert_data);
                }
            }
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeSessionProductItem(Request $request)
    {
        try {
            SessionProduct::find($request->id)->update(['quantity' => $request->quantity]);
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeSalida(Request $request)
    {
        $from = Auth::user()->store_active;
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();
            $list_id = $request->input('session_list_id');
            $explode = explode('_', $list_id);

            $session_products = $this->sessionProductRepository->getByListId($list_id);

            foreach ($session_products as $product) {
                $cantidad = ($product->unit_type == 'K') ? ($product->producto->unit_weight * $product->unit_package * $product->quantity) : ($product->unit_package * $product->quantity);
                $balance  = $product->producto->stockReal(null, \Auth::user()->store_active);
                if ($balance < $cantidad) {
                    $alert = '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                    $alert .= '<i class="ace-icon fa fa-ban"></i> COD-FENOVO <strong>';
                    $alert .= $product->producto->cod_fenovo .'</strong> insuficiente. Imposible vender <strong>';
                    $alert .= $cantidad .'</strong>, porque el stock actual es <strong>';
                    $alert .= $balance .'</strong>'. $product->producto->unit_type .'</div>';

                    return new JsonResponse(['msj' => 'Stock Insuficiente', 'type' => 'error', 'alert' => $alert]);
                }
            }

            if ($explode[0] != 'TRASLADO') {
                $count = Movement::where('from', $from)->whereIn('type', ['VENTA', 'VENTACLIENTE'])->count();
            } else {
                $count = Movement::where('from', $from)->where('type', 'TRASLADO')->count();
            }

            $orden = ($count) ? $count + 1 : 1;

            $insert_data['type']           = $explode[0];
            $insert_data['to']             = $explode[1];
            $insert_data['date']           = now();
            $insert_data['from']           = $from;
            $insert_data['orden']          = $orden;
            $insert_data['status']         = 'FINISHED';
            $insert_data['voucher_number'] = $request->input('voucher_number');
            $insert_data['flete']          = $request->flete;
            $insert_data['observacion']    = $request->observacion;
            $insert_data['user_id']        = \Auth::user()->id;
            $insert_data['flete_invoice']  = (isset($request->factura_flete)) ? 1 : 0;

            $movement = Movement::create($insert_data);

            $enitidad_tipo = parent::getEntidadTipo($insert_data['type']);

            $pto_vta       = $cuit       = $iva_type       = '';
            $cliente       = null;
            $insert_panama = false;

            if ($explode[0] == 'VENTA' || $explode[0] == 'TRASLADO') {
                $cliente = Store::where('id', $explode[1])->with('region')->first();
                $pto_vta = 'PVTA_' . str_pad($cliente->cod_fenovo, 3, '0', STR_PAD_LEFT);
            } elseif ($explode[0] == 'VENTACLIENTE') {
                $cliente = Customer::where('id', $explode[1])->with('store')->first();
                $pto_vta = 'CLI_' . str_pad($cliente->id, '0', 3, STR_PAD_LEFT);
            }

            if ($cliente) {
                $cuit1    = substr($cliente->cuit, 0, 2);
                $cuit2    = substr($cliente->cuit, 2, 8);
                $cuit3    = substr($cliente->cuit, 10, 1);
                $cuit     = $cuit1 . '-' . $cuit2 . '-' . $cuit3;
                $iva_type = ($cliente->iva_type == 'RI') ? 'I' : $cliente->iva_type;
            }

            foreach ($session_products as $product) {
                $cantidad = ($product->unit_type == 'K') ? ($product->producto->unit_weight * $product->unit_package * $product->quantity) : ($product->unit_package * $product->quantity);

                // resta del balance de la store fenovo porque es salida
                $latest = MovementProduct::select('balance')
                    ->where('entidad_id', $from)
                    ->where('entidad_tipo', 'S')
                    ->where('product_id', $product->product_id)
                    ->orderBy('id','DESC')->first();

                $balance = ($latest) ? $latest->balance - $cantidad : 0;
                MovementProduct::updateOrCreate([
                    'entidad_id'      => $from,
                    'entidad_tipo'    => 'S',
                    'movement_id'     => $movement->id,
                    'product_id'      => $product->product_id,
                    'unit_package'    => $product->unit_package, ], [
                        'invoice'     => $product->invoice,
                        'iibb'        => $product->iibb,
                        'unit_price'  => ($product->invoice) ? $product->unit_price : $product->neto,
                        'cost_fenovo' => $product->costo_fenovo,
                        'tasiva'      => $product->tasiva,
                        'unit_type'   => $product->unit_type,
                        'entry'       => 0,
                        'bultos'      => $product->quantity,
                        'egress'      => $cantidad,
                        'balance'     => $balance,
                    ]);

                if ($insert_data['type'] != 'VENTACLIENTE') {
                    // Suma al balance de la store to
                    $latest = MovementProduct::select('balance')
                        ->where('entidad_id', $insert_data['to'])
                        ->where('entidad_tipo', $enitidad_tipo)
                        ->where('product_id', $product->product_id)
                        ->orderBy('id','DESC')->first();

                    $balance = ($latest) ? $latest->balance + $cantidad : $cantidad;
                    MovementProduct::updateOrCreate([
                        'entidad_id'      => $insert_data['to'],
                        'entidad_tipo'    => $enitidad_tipo,
                        'movement_id'     => $movement->id,
                        'product_id'      => $product->product_id,
                        'unit_package'    => $product->unit_package, ], [
                            'invoice'     => $product->invoice,
                            'bultos'      => $product->quantity,
                            'cost_fenovo' => $product->costo_fenovo,
                            'entry'       => $cantidad,
                            'unit_price'  => ($product->invoice) ? $product->unit_price : $product->neto,
                            'tasiva'      => $product->tasiva,
                            'unit_type'   => $product->unit_type,
                            'egress'      => 0,
                            'balance'     => $balance,
                        ]);
                } else {
                    MovementProduct::updateOrCreate([
                        'entidad_id'      => $insert_data['to'],
                        'entidad_tipo'    => $enitidad_tipo,
                        'movement_id'     => $movement->id,
                        'product_id'      => $product->product_id,
                        'unit_package'    => $product->unit_package, ], [
                            'invoice'     => $product->invoice,
                            'bultos'      => $product->quantity,
                            'cost_fenovo' => $product->costo_fenovo,
                            'entry'       => $cantidad,
                            'unit_price'  => ($product->invoice) ? $product->unit_price : $product->neto,
                            'tasiva'      => $product->tasiva,
                            'unit_type'   => $product->unit_type,
                            'egress'      => 0,
                            'balance'     => $balance,
                        ]);
                }

                if (!$product->invoice) {
                    $insert_panama = true;
                }
            }

            $count = Panamas::orderBy('orden', 'DESC')->first();
            $orden = (isset($count)) ? $count->orden : 1;

            $data_panama                    = [];
            $data_panama['movement_id']     = $movement->id;
            $data_panama['client_name']     = ($cliente) ? $cliente->razon_social : '';
            $data_panama['client_address']  = ($cliente) ? $cliente->address : '';
            $data_panama['client_cuit']     = $cuit;
            $data_panama['client_iva_type'] = $iva_type;
            $data_panama['pto_vta']         = $pto_vta;

            if ($insert_panama) {
                $orden += 1;
                $data_panama['tipo']               = 'PAN';
                $data_panama['orden']              = $orden;
                $data_panama['neto105']            = (is_null($movement->neto105(false))     || is_null($movement->neto105(false)->neto105)) ? '0.0' : $movement->neto105(false)->neto105;
                $data_panama['iva_neto105']        = (is_null($movement->neto105(false))     || is_null($movement->neto105(false)->neto_iva105)) ? '0.0' : $movement->neto105(false)->neto_iva105;
                $data_panama['neto21']             = (is_null($movement->neto21(false))      || is_null($movement->neto21(false)->neto21)) ? '0.0' : $movement->neto21(false)->neto21;
                $data_panama['iva_neto21']         = (is_null($movement->neto21(false))      || is_null($movement->neto21(false)->neto_iva21)) ? '0.0' : $movement->neto21(false)->neto_iva21;
                $data_panama['totalIibb']          = (is_null($movement->totalIibb(false))   || is_null($movement->totalIibb(false)->total_no_gravado)) ? '0.0' : $movement->totalIibb(false)->total_no_gravado;
                $data_panama['totalConIva']        = (is_null($movement->totalConIva(false)) || is_null($movement->totalConIva(false)->totalConIva)) ? '0.0' : $movement->totalConIva(false)->totalConIva;
                $data_panama['costo_fenovo_total'] = (is_null($movement->cosventa(false))    || is_null($movement->cosventa(false)->cost_venta)) ? '0.0' : $movement->cosventa(false)->cost_venta;

                Panamas::create($data_panama);
            }

            if (!isset($request->factura_flete) && $request->flete > 0) {
                $data_panama['tipo']               = 'FLE';
                $data_panama['orden']              = $orden + 1;
                $data_panama['neto105']            = 0.0;
                $data_panama['iva_neto105']        = 0.0;
                $data_panama['neto21']             = $request->flete;
                $data_panama['iva_neto21']         = $request->flete * 0.21;
                $data_panama['totalIibb']          = 0.0;
                $data_panama['totalConIva']        = $request->flete;
                $data_panama['costo_fenovo_total'] = 0.0;

                Panamas::create($data_panama);
            }

            $this->sessionProductRepository->deleteList($list_id);
            DB::commit();
            Schema::enableForeignKeyConstraints();
            return new JsonResponse(['msj' => 'Salida cerrada correctamente', 'type' => 'success']);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function changeInvoiceProduct(Request $request)
    {
        try {
            $listId                   = $request->input('list_id');
            $session_product          = $this->sessionProductRepository->getByListIdAndProduct($listId, $request->input('product_id'));
            $session_product->invoice = !$session_product->invoice;
            $session_product->save();
            return new JsonResponse(['msj' => 'Facturación cambiada', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function pendienteDestroy(Request $request)
    {
        SessionProduct::where('list_id', $request->list_id)->delete();
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }

    public function cambiarPausaSalida(Request $request){
        $productos_en_session = SessionProduct::where('list_id', $request->list_id)->where('pausado', $request->id_pausado)->get();
        $id_pausado = rand(1111111111,9999999999);
        foreach ($productos_en_session as $ps) {
            $ps->pausado = (is_null($ps->pausado))?$id_pausado:null;
            $ps->save();
        }
        return new JsonResponse(
            [
                'msj'  => 'Se cambio el pausado a la salida. ',
                'type' => 'success',
            ]
        );
    }

    public function updateStockFactura(){
        $productos = Product::all();
        foreach ($productos as $p) {
            $p->stock_f = $p->stockParaActualizacion();
            $p->save();
        }
    }

    public function updateStock()
    {
        $products = Product::all();

        foreach ($products as $p) {
            $movements_products = MovementProduct::where('movement_id', '>', 1633)
                                        ->where('product_id', $p->id)
                                        ->where('entidad_id', 1)
                                        ->orderBy('id', 'ASC')
                                        ->get();

            for ($i = 0; $i < count($movements_products); $i++) {
                $mp = $movements_products[$i];
                $m  = Movement::where('id', $mp->movement_id)->first();

                if ($i == 0) {
                    $balance_orig = $new_balance = $mp->balance;
                }

                if ($i > 0) {
                    $bultos = $mp->bultos * $mp->unit_package;

                    if ($mp->entry > 0) {
                        $new_balance  = $balance_orig + $bultos;
                        $balance_orig = $new_balance;

                        MovementProduct::where('id', $mp->id)->update([
                            'balance' => $new_balance,
                            'entry'   => $bultos,
                        ]);
                    } elseif ($mp->egress > 0) {
                        $new_balance  = $balance_orig - $bultos;
                        $balance_orig = $new_balance;

                        MovementProduct::where('id', $mp->id)->update([
                            'balance' => $new_balance,
                            'egress'  => $bultos,
                        ]);
                    }
                }
            }
        }
    }

    public function updateJurisdiccion(){
        $invoices = Invoice::all();
        foreach ($invoices as $invoice) {
            $mov = Movement::where('id',$invoice->movement_id)->first();
            $store = $mov->To($mov->type,true);
            $juris = $this->getJurisdiccion($store->state);
            $invoice->jurisdiccion = $juris;
            $invoice->save();
        }
    }

    private function getJurisdiccion($loc){
        switch ($loc) {
            case 'Santa Fe':
                return 921;
                break;
            case 'Entre Ríos':
                return 908;
                break;
            case 'Misiones':
                return 914;
                break;
            case 'Buenos Aires':
                return 902;
                break;
            case 'Chaco':
                return 906;
                break;
            case 'Córdoba':
                return 904;
                break;
            case 'Corrientes':
                return 905;
                break;
            case 'San Luis':
                return 919;
                break;
            default:
                return null;
                break;
        }
    }
}
