<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Exports\OrdenConsolidadaViewExport;
use App\Http\Controllers\Controller;
use App\Mail\NovedadMail;
use App\Models\Coeficiente;
use App\Models\Customer;
use App\Models\FleteSetting;
use App\Models\Invoice;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\OfertaStore;
use App\Models\Panamas;
use App\Models\Pedido;
use App\Models\PedidoEstados;
use App\Models\PedidoProductos;
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
use Barryvdh\DomPDF\Facade as PDF;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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

            // Tomo los movimientos de 90 dias atras
            $fecha = Carbon::now()->subDays(90)->toDateTimeString();
            if(\Auth::user()->rol() == 'superadmin' || \Auth::user()->rol() == 'admin'){
                $movement = Movement::where('from', Auth::user()->store_active)
                    ->whereIn('type', $arrTypes)
                    ->whereDate('created_at', '>', $fecha)
                    ->orderBy('date', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->get();
            }else{
                $movement = Movement::where('from', Auth::user()->store_active)
                ->whereIn('type', $arrTypes)
                ->where('user_id', Auth::user()->id)
                ->whereDate('created_at', '>', $fecha)
                ->orderBy('date', 'DESC')
                ->orderBy('id', 'DESC')
                ->get();
            }


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
                ->editColumn('observacion', function ($movement) {
                    return ($movement->observacion == 'VENTA DIRECTA') ? '<i class="fa fa-check-circle text-dark"></i>' : null;
                })
                ->editColumn('factura_nro', function ($movement) {
                    if ($movement->type == 'VENTA' || $movement->type == 'VENTACLIENTE' || $movement->type == 'TRASLADO') {
                        if (isset($movement->invoice) && count($movement->invoice)) {
                            $urls = '';
                            foreach ($movement->invoice as $invoice) {
                                if (!is_null($invoice->cae) && !is_null($invoice->url)) {
                                    $number = ($invoice->cyo) ? 'CyO - ' . $invoice->voucher_number : $invoice->voucher_number;
                                    $urls .= '<a class="text-primary" title="Descargar factura" target="_blank" href="' . $invoice->url . '"> ' . $number . ' </a><br>';
                                } elseif (!is_null($invoice->cae) && is_null($invoice->url)) {
                                    $number = ($invoice->cyo) ? 'CyO - ' . $invoice->voucher_number : $invoice->voucher_number;
                                    $urls .= '<a class="text-primary" title="Generar factura" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '">' . $number . ' </a><br>';
                                }
                            }
                            return $urls;
                        }
                        if ($movement->status != 'FINISHED_AND_GENERATED_FACT') {
                            return '<a href="' . route('pre.invoice', ['movment_id' => $movement->id]) . '">Generar Factura </a>';
                        }
                        return '--';
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
                    return ($movement->hasPanama() || count($movement->panamas))
                        ? '<a title="Imprimir Orden panama"  href="' . route('print.ordenPanama', ['id' => $movement->id]) . '" target="_blank"> <i class="fas fa-list"></i> </a>'
                        : null;
                })

                ->rawColumns(['id', 'origen', 'items', 'date', 'type', 'observacion', 'factura_nro', 'remito', 'paper', 'flete', 'orden', 'ordenpanama'])
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
                    if(!is_null($pendiente->a_deposito)){
                        $explode = explode('_', $pendiente->list_id);
                        $obj = $this->origenDataCiudad('TRASLADO', $pendiente->a_deposito,true);
                        return $obj->razon_social;
                    }else{
                        $explode = explode('_', $pendiente->list_id);
                        return $this->origenDataCiudad($explode[0], $explode[1]);
                    }

                })
                ->addColumn('items', function ($pendiente) {
                    return '<span class="badge badge-primary">' . $pendiente->total . '</span>';
                })
                ->addColumn('destroy', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        if (in_array(Auth::user()->rol(), ['superadmin', 'admin'])) {
                            $ruta = "motivoPendiente('" . $pendiente->list_id . "')";
                            return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                        }
                    }
                    return '';
                })
                ->addColumn('pausar', function ($pendiente) {
                    $pausado = (!is_null($pendiente->pausado)) ? '<label style="color:red;font-size:9px">Pausado</label>' : '';
                    $action  = "pausarSalida('" . $pendiente->list_id . "','" . $pendiente->pausado . "')";
                    return '<a href="javascript:void(0)" onclick="' . $action . '" > <i class="fa fa-retweet" aria-hidden="true"></i> ' . $pausado . ' </a>';
                })
                ->addColumn('edit', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        return '<a href="' . route('salidas.pendiente.show', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-pencil-alt"></i> </a>';
                    }
                    return '';
                })
                ->addColumn('print', function ($pendiente) {
                    if (is_null($pendiente->pausado)) {
                        return '<a target="_blank" href="' . route('salidas.pendiente.print', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-print"></i> </a>';
                    }
                    return '';
                })
                ->rawColumns(['actualizacion', 'items', 'destino', 'edit', 'destroy', 'print', 'pausar'])
                ->make(true);
        }
        return view('admin.movimientos.salidas.pendientes');
    }

    public function pendienteShow(Request $request)
    {
        $pedido  = $desde_deposito = $a_deposito = $destino = $destinoName = null;
        $depositos = null;
        $es_traslado_depositos = false;
        $list_id = $request->input('list_id');

        $explode = explode('_', $list_id);
        $tipo        = $explode[0];

        $sp = SessionProduct::where('list_id',$list_id)->first();
        if(\Auth::user()->rol() == 'contable'){
            if(isset($sp) && !is_null($sp->desde_deposito)){
                $desde_deposito = $this->origenData($tipo, $sp->desde_deposito, true);
                $es_traslado_depositos = true;
            }
            if(isset($sp) && !is_null($sp->a_deposito)){
                $a_deposito = $this->origenData($tipo, $sp->a_deposito, true);
                $es_traslado_depositos = true;
            }

            $depositos = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type','D')->get();
        }

        if(isset($sp) && !is_null($sp->nro_pedido)){
            $pedido = $sp->nro_pedido;
        }

        if(!$es_traslado_depositos){
            $destino     = $this->origenData($tipo, $explode[1], true);
            $destinoName = $this->origenData($tipo, $explode[1]);
        }

        return view('admin.movimientos.salidas.add',
               compact('tipo', 'destino', 'destinoName', 'pedido', 'list_id','es_traslado_depositos','desde_deposito','a_deposito','depositos'));
    }

    public function getTotalMovement(Request $request)
    {
        $total    = 0;
        $movement = Movement::query()->where('id', $request->input('movement_id'))->first();
        $products = ($movement->type == 'TRASLADO') ? $movement->products_egress : $movement->movement_salida_products;
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
        $list_id = $request->list_id; //. '_' . \Auth::user()->store_active;

        $session_products = DB::table('session_products as t1')
            ->join('products as t2', 't1.product_id', '=', 't2.id')
            ->select('t1.id', 't2.cod_fenovo', 't2.name', 't2.cod_proveedor', 't1.quantity', 't2.unit_weight', 't1.unit_package', 't2.unit_type')
            ->where('t1.list_id', '=', $list_id)
            ->whereNull('pausado')
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
        $movement = Movement::whereId($orden)->first();

        if ($movement) {
            if ($movement->type == 'TRASLADO') {
                $store = Store::find($movement->to);
                if (isset($store) && ($store->store_type == 'B')) {
                    $mercaderia_en_transito = 'MERCADERIA EN TRANSITO';
                }
            }
            $destino         = $this->origenData($movement->type, $movement->to, true);
            $array_productos = [];
            $movimientos     = ($movement->type == 'TRASLADO') ? $movement->group_products_egress : $movement->group_movement_salida_products;
            foreach ($movimientos as $movimiento) {
                if ($movimiento->invoice) {
                    $objProduct               = new stdClass();
                    $objProduct->cod_fenovo   = $movimiento->product->cod_fenovo;
                    $objProduct->name         = $movimiento->product->name;
                    $objProduct->unit_weight  = $movimiento->product->unit_weight;
                    $objProduct->unit_type    = $movimiento->unit_type;
                    $objProduct->unit_package = $movimiento->unit_package;
                    $objProduct->quantity     = $movimiento->bultos;
                    $objProduct->palet        = $movimiento->product->palet . $movimiento->palet;
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
            $movimientos     = $movement->panamas;
            foreach ($movimientos as $movimiento) {
                $objProduct               = new stdClass();
                $objProduct->cod_fenovo   = $movimiento->product->cod_fenovo;
                $objProduct->name         = $movimiento->product->name;
                $objProduct->unit_weight  = $movimiento->product->unit_weight;
                $objProduct->unit_package = $movimiento->unit_package;
                $objProduct->palet        = $movimiento->product->palet . $movimiento->palet;
                $objProduct->quantity     = $movimiento->bultos;
                $objProduct->unity        = '( ' . $movimiento->unit_package . ' ' . $movimiento->product->unit_type . ' )';
                $objProduct->total_unit   = number_format($movimiento->bultos * $movimiento->unit_package, 2, ',', '.');
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
                $objProduct->palet        = $producto->palet;
                $objProduct->quantity     = $producto->bultos;
                $objProduct->unity        = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                $objProduct->total_unit   = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->class        = '';
                array_push($array_productos, $objProduct);
            }
        }

        // Guarda el PDF en la carpeta public

        $orden = 'exportacion/orden-' . $request->id . '.pdf';
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
            $objProduct->palet        = $producto->palet;
            $objProduct->quantity     = $producto->bultos;
            $objProduct->unity        = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
            $objProduct->total_unit   = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
            $objProduct->class        = '';
            array_push($array_productos, $objProduct);
        }

        $ordenp = 'exportacion/ordenp-' . $request->id . '.pdf';
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

        $store_from = Store::where('id', $movement->from)->first();
        $cip        = (is_null($store_from->cip)) ? '8889' : $store_from->cip;

        if ($movement) {
            $id_flete               = $cip . '-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
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
        $movement = Movement::query()->where('id', $request->input('movement_id'))->first();
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
            $productos       = ($movement->type == 'TRASLADO') ? $movement->group_products_egress : $movement->group_movement_salida_products;

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

        $store_from = Store::where('id', $movement->from)->first();
        $cip        = (is_null($store_from->cip)) ? '8889' : $store_from->cip;

        if ($movement) {
            $id_panama       = $cip . '-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
            $destino         = $this->origenData($movement->type, $movement->to, false);
            $fecha           = \Carbon\Carbon::parse($panama->created_at)->format('d/m/Y');
            $neto            = 0;
            $array_productos = [];
            $productos       = $movement->group_panamas;
            foreach ($productos as $producto) {
                $subtotal               = $producto->bultos * $producto->unit_price * $producto->unit_package;
                $objProduct             = new stdClass();
                $objProduct->cant       = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->bultos     = $producto->bultos;
                $objProduct->unidad     = $producto->product->unit_type;
                $objProduct->cod_fenovo = $producto->product->cod_fenovo;
                $objProduct->codigo     = $producto->product->cod_fenovo;
                $objProduct->name       = $producto->product->name;
                $objProduct->palet      = $producto->palet;
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
        $depositos = null;
        if(\Auth::user()->rol() == 'contable'){
            $depositos = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->where('store_type','D')->get();
        }
        $this->sessionProductRepository->deleteDevoluciones();
        return view('admin.movimientos.salidas.add',compact('depositos'));
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
            $stores = $this->storeRepository->search($term, $request->to_type);
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
                $stock = $product->stock_f + $product->stock_r + $product->stock_cyo;
                if (!$stock) {
                    $text_no_stock = ' -- SIN STOCK --';
                } else {
                    $text_no_stock = '(' . $stock . ' ' . $product->unit_type . ')';
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
            $list_id = $request->input('list_id');
            if (count(explode('_', $list_id)) == 2) {
                $list_id .= '_' . Auth::user()->store_active;
            }
            $session_products      = $this->sessionProductRepository->getByListId($list_id);
            $mostrar_check_invoice = false; //!(str_contains($list_id, 'DEVOLUCION_') || str_contains($list_id, 'DEBITO_'));
            return new JsonResponse([
                'type' => $list_id,
                'html' => view('admin.movimientos.salidas.partials.form-table-products', compact('session_products', 'mostrar_check_invoice'))->render(),
            ]);
        } catch (\Exception $e) {
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function getFleteSessionProducts(Request $request)
    {
        try {
            $list_id = $request->input('list_id') . '_' . \Auth::user()->store_active;
            $total   = $request->input('total_from_session');
            $km      = $this->sessionProductRepository->getFlete($list_id);
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
                $producto_en_depositos = '';
                $product    = $this->productRepository->getById($request->input('id'));
                $list_id    = $request->input('list_id') . '_' . \Auth::user()->store_active;
                $devolucion = str_contains($list_id, 'DEVOLUCION_');
                $debito     = str_contains($list_id, 'DEBITO_');
                $es_traslado   = str_contains($list_id, 'TRASLADO_');
                $depositos = $desposito_desde_seleccionado = null;

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
                    } elseif(\Auth::user()->rol() == 'contable'){
                        $explode = explode('-',$request->input('list_id'));
                        $desposito_desde_seleccionado = explode('_',$explode[0])[1];
                        $producto_en_depositos = ProductStore::where('product_id',$request->input('id'))->with('deposito')->get();
                        $view = 'admin.movimientos.salidas.partials.inserByAjaxWithDepositos';
                    } else{if(\Auth::user()->rol() != 'contable')
                        $view = 'admin.movimientos.salidas.partials.inserByAjax';
                    }

                    return new JsonResponse([
                        'type' => 'success',
                        'html' => view(
                            $view,
                            compact('stock_presentaciones', 'product', 'presentaciones', 'stock_total', 'stock_session','producto_en_depositos','es_traslado','desposito_desde_seleccionado')
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
            $deposito            = $request->input('deposito');
            $a_deposito          = $request->input('a_deposito');
            $desde_deposito      = $request->input('desde_deposito');
            $list_id             = $request->input('list_id');
            $nro_pedido          = $request->input('nro_pedido');

            if (count(explode('_', $list_id)) == 2) {
                $list_id .= '_' . Auth::user()->store_active;
            }

            if ((\Auth::user()->rol() != 'contable' && !$to) ||
                (\Auth::user()->rol() == 'contable' && !$to && $to_type != 'TRASLADO')  ) {
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

            if(\Auth::user()->rol() == 'contable' && is_null($deposito) && $to_type != 'TRASLADO'){
                return new JsonResponse(['msj' => 'Debe seleccionar despósito de origen.', 'type' => 'error', 'index' => 'deposito']);
            }

            if(\Auth::user()->rol() == 'contable' && ($a_deposito == $desde_deposito) && isset($a_deposito) && isset($desde_deposito)){
                return new JsonResponse(['msj' => 'Debe seleccionar despósitos de origen y destino diferentes. ', 'type' => 'error', 'index' => 'deposito']);
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
            $insert_data['list_id']      = $list_id;
            $insert_data['store_id']     = Auth::user()->store_active;
            $insert_data['user_id']      = Auth::user()->id;
            $insert_data['invoice']      = true;
            $insert_data['circuito']     = null;
            $insert_data['iibb']         = $product->iibb;
            $insert_data['product_id']   = $product_id;
            $insert_data['deposito']     = ($desde_deposito)?$desde_deposito:$deposito;
            $insert_data['desde_deposito']= $desde_deposito;
            $insert_data['a_deposito']    = $a_deposito;
            $insert_data['nro_pedido']    = $nro_pedido;

            for ($i = 0; $i < count($unidades); $i++) {
                $unidad   = $unidades[$i];
                $quantity = (float)$unidad['value'];

                if ($quantity > 0) {
                    $explode                     = explode('_', $unidad['name']);
                    $insert_data['unit_package'] = $explode[1];
                    $stock_en_session            = $this->sessionProductRepository->getCantidadTotalDeBultosByListId($product_id, $insert_data['unit_package'], $insert_data['list_id']);
                    $insert_data['quantity']     = $quantity + $stock_en_session;
                    $this->sessionProductRepository->updateOrCreate($insert_data);
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
            if ($request->quantity) {
                SessionProduct::find($request->id)->update(['quantity' => $request->quantity]);
            }
            if ($request->palet) {
                SessionProduct::find($request->id)->update(['palet' => $request->palet]);
            }
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    private function checkStockPass($products)
    {
        foreach ($products as $product) {
            $cantidad = ($product->unit_type == 'K') ? ($product->producto->unit_weight * $product->unit_package * $product->quantity) : ($product->unit_package * $product->quantity);
            $balance  = $product->producto->stockReal();
            if ($balance < $cantidad) {
                $alert = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert"><i class="ace-icon fa fa-times"></i></button>';
                $alert .= '<i class="ace-icon fa fa-ban"></i> COD-FENOVO <strong>';
                $alert .= $product->producto->cod_fenovo . '</strong> insuficiente. Imposible vender <strong>';
                $alert .= $cantidad . '</strong>, porque el stock actual es <strong>';
                $alert .= $balance . '</strong>' . $product->producto->unit_type . '</div>';

                return ['type' => 'error', 'alert' => $alert];
            }
        }
        return ['type' => 'success'];
    }

    private function getStockDividido($product)
    {
        $qty_f    = $qty_r    = $qty_cyo    = $diff    = 0;
        $producto = $product->producto;

        $SR     = (!is_null($producto->stock_r)) ? $producto->stock_r : 0;
        $SF     = (!is_null($producto->stock_f)) ? $producto->stock_f : 0;
        $SCYO   = (!is_null($producto->stock_cyo)) ? $producto->stock_cyo : 0;
        $ST     = $SF + $SR;
        $coef_f = ($ST > 0) ? (int)round(($SF * 100) / $ST) : 0;

        $quantity     = $product->quantity;
        $unit_type    = $product->unit_type;
        $unit_weight  = $producto->unit_weight;
        $unit_package = $product->unit_package;

        if ($quantity > 0) {
            $cant_total = ($unit_type == 'K') ? ($unit_weight * $unit_package * $quantity) : ($unit_package * $quantity);

            // Primero debo buscar el stock en F Y R Luego buscar en CYO si ninguno de los tres llega a cubrir la cantidad solicitada
            // pero hay algo en stock debo tomar lo que hay
            $total_r   = ($unit_type == 'K') ? ($SR   / ($unit_weight * $unit_package)) : ($SR   / $unit_package);
            $total_cyo = ($unit_type == 'K') ? ($SCYO / ($unit_weight * $unit_package)) : ($SCYO / $unit_package);
            $total_f   = ($unit_type == 'K') ? ($SF   / ($unit_weight * $unit_package)) : ($SF   / $unit_package);

            if ($cant_total <= $ST) {
                $qty_f = round((($coef_f * $quantity) / 100), 0, PHP_ROUND_HALF_UP);
                $qty_r = $quantity - $qty_f;
            } elseif ($cant_total <= ($ST + $SCYO)) {
                $qty_f   = $total_f;
                $qty_r   = $total_r;
                $qty_cyo = (int)($quantity - $qty_f - $qty_r);
            } elseif (($ST + $SCYO) > 0) {
                $qty_r   = $total_r;
                $qty_cyo = $total_cyo;
                $qty_f   = $total_f;
                $diff    = $quantity - $qty_r - $qty_cyo - $qty_f;
                $qty_f += $diff;
            } elseif (($ST + $SCYO) == 0) {
                $qty_f = $quantity;
            }
            $quantities[0] = ['tipo' => 'quantity_f', 'cant' => $qty_f];
            $quantities[1] = ['tipo' => 'quantity_r', 'cant' => $qty_r];
            $quantities[2] = ['tipo' => 'quantity_cyo', 'cant' => $qty_cyo];
            return $quantities;
        }
        return [];
    }

    public function storeSalida(Request $request)
    {
        try {
            $from = 1;
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();
                $list_id = $request->input('session_list_id');
                if (count(explode('_', $list_id)) == 2) {
                    $list_id .= '_' . Auth::user()->store_active;
                }
                $explode          = explode('_', $list_id);
                $session_products = $this->sessionProductRepository->getByListId($list_id);

                $check = $this->checkStockPass($session_products);
                if ($check['type'] == 'error') {
                    return new JsonResponse(['msj' => 'Stock Insuficiente', 'type' => 'error', 'alert' => $check['alert']]);
                }

                if ($explode[0] != 'TRASLADO') {
                    $count = Movement::where('from', $from)->whereIn('type', ['VENTA', 'VENTACLIENTE'])->count();
                } else {
                    $count = Movement::where('from', $from)->where('type', 'TRASLADO')->count();
                }

                $orden = ($count) ? $count + 1 : 1;

                $es_traslado_a_deposito = $session_products[0]->a_deposito;
                $es_pedido              = $session_products[0]->nro_pedido;
                $desde_pedido           = $session_products[0]->desde_deposito;

                $insert_data['type']           = $explode[0];
                $insert_data['to']             = ($es_traslado_a_deposito)?$es_traslado_a_deposito:$explode[1];
                $insert_data['date']           = now();
                $insert_data['from']           = ($desde_pedido)?$desde_pedido:$from;
                $insert_data['orden']          = $orden;
                $insert_data['status']         = 'FINISHED';
                $insert_data['voucher_number'] = $request->input('voucher_number');
                $insert_data['flete']          = $request->flete;
                $insert_data['observacion']    = $request->observacion;
                $insert_data['user_id']        = \Auth::user()->id;
                $insert_data['flete_invoice']  = (isset($request->factura_flete)) ? 1 : 0;
                // Movimiento
                $movement = Movement::create($insert_data);
                // Si es un Pedido
                if ($es_pedido) {
                    $voucher_number      = $es_pedido;
                    $pedido              = Pedido::where('voucher_number', $voucher_number)->first();
                    $pedido->movement_id = $movement->id;
                    $pedido->status      = 'FINISHED';
                    $pedido->save();

                    PedidoEstados::create([
                        'user_id'   => \Auth::user()->id,
                        'pedido_id' => $pedido->id,
                        'fecha'     => now(),
                        'estado'    => 'CERRADO',
                    ]);
                }

                $entidad_tipo = parent::getEntidadTipo($insert_data['type']);

                foreach ($session_products as $product) {
                    $stock_inicial_store = 0;
                    $quantities          = $this->getStockDividido($product);
                    $stock_inicial       = $product->producto->stockReal();
                    $cantidad            = $product->quantity;
                    $punto_venta         = env('PTO_VTA_FENOVO', 18);
                    $unit_type           = $product->unit_type;
                    $unit_weight         = $product->producto->unit_weight;
                    $unit_package        = $product->unit_package;
                    $palet               = $product->palet;

                    $deposito       = $product->deposito;
                    $desde_deposito = $product->desde_deposito;
                    $a_deposito     = $product->a_deposito;

                    if (isset($quantities[0])) {
                        $cant_total_f = ($unit_type == 'K') ? ($unit_weight * $unit_package * $quantities[0]['cant']) : ($unit_package * $quantities[0]['cant']);
                        $product->producto->stock_f -= $cant_total_f;
                    }
                    if (isset($quantities[1])) {
                        $cant_total_r = ($unit_type == 'K') ? ($unit_weight * $unit_package * $quantities[1]['cant']) : ($unit_package * $quantities[1]['cant']);
                        $product->producto->stock_r -= $cant_total_r;
                    }
                    if (isset($quantities[2])) {
                        $cant_total_cyo = ($unit_type == 'K') ? ($unit_weight * $unit_package * $quantities[2]['cant']) : ($unit_package * $quantities[2]['cant']);
                        $product->producto->stock_cyo -= $cant_total_cyo;
                        $punto_venta = $product->producto->proveedor->punto_venta;
                    }

                    $cant_total = $cant_total_f + $cant_total_r + $cant_total_cyo;
                    if(!$es_traslado_a_deposito) $product->producto->save();

                    if ($insert_data['type'] != 'VENTACLIENTE') {

                        if($deposito){
                            $prod_store = ProductStore::where('product_id', $product->product_id)->where('store_id', $deposito)->first();
                        }else{
                            $prod_store = ProductStore::where('product_id', $product->product_id)->where('store_id', $insert_data['to'])->first();
                        }

                        $stock_inicial_store = ($prod_store) ? $prod_store->stock_f + $prod_store->stock_r + $prod_store->stock_cyo : 0;

                        if ($prod_store) {
                            if (isset($quantities[0])) {
                                ($deposito) ? $prod_store->stock_f -= $cant_total_f : $prod_store->stock_f += $cant_total_f;
                            }
                            if (isset($quantities[1])) {
                                ($deposito) ? $prod_store->stock_r -= $cant_total_r : $prod_store->stock_r += $cant_total_r;
                            }
                            if (isset($quantities[2])) {
                                ($deposito) ? $prod_store->stock_cyo -= $cant_total_cyo : $prod_store->stock_cyo += $cant_total_cyo;
                            }
                            $prod_store->save();
                        } else {
                            $data_prod_store['product_id'] = $product->product_id;
                            $data_prod_store['store_id']   = $insert_data['to'];
                            if (isset($quantities[0])) {
                                $data_prod_store['stock_f'] = $cant_total_f;
                            }
                            if (isset($quantities[1])) {
                                $data_prod_store['stock_r'] = $cant_total_r;
                            }
                            if (isset($quantities[2])) {
                                $data_prod_store['stock_cyo'] = $cant_total_cyo;
                            }
                            ProductStore::create($data_prod_store);
                        }

                        if($a_deposito){
                            $prod_a_depsito = ProductStore::where('product_id', $product->product_id)->where('store_id', $a_deposito)->first();
                            if ($prod_a_depsito) {
                                if (isset($quantities[0])) $prod_a_depsito->stock_f += $cant_total_f;
                                if (isset($quantities[1])) $prod_a_depsito->stock_r += $cant_total_r;
                                if (isset($quantities[2])) $prod_a_depsito->stock_cyo += $cant_total_cyo;
                                $prod_a_depsito->save();
                            } else {
                                $data_prod_a_deposito['product_id'] = $product->product_id;
                                $data_prod_a_deposito['store_id']   = $a_deposito;
                                if (isset($quantities[0]))  $data_prod_a_deposito['stock_f'] = $cant_total_f;
                                if (isset($quantities[1]))  $data_prod_a_deposito['stock_r'] = $cant_total_r;
                                if (isset($quantities[2]))  $data_prod_a_deposito['stock_cyo'] = $cant_total_cyo;
                                ProductStore::create($data_prod_a_deposito);
                            }
                        }
                    }else{
                        if($deposito){
                            $prod_store = ProductStore::where('product_id', $product->product_id)->where('store_id', $deposito)->first();
                            $stock_inicial_store = ($prod_store) ? $prod_store->stock_f + $prod_store->stock_r + $prod_store->stock_cyo : 0;

                            if ($prod_store) {
                                if (isset($quantities[0])) {
                                    ($deposito) ? $prod_store->stock_f -= $cant_total_f : null;
                                }
                                if (isset($quantities[1])) {
                                    ($deposito) ? $prod_store->stock_r -= $cant_total_r : null;
                                }
                                if (isset($quantities[2])) {
                                    ($deposito) ? $prod_store->stock_cyo -= $cant_total_cyo : null;
                                }
                                $prod_store->save();
                            } else {
                                $data_prod_store['product_id'] = $product->product_id;
                                $data_prod_store['store_id']   = $insert_data['to'];
                                if (isset($quantities[0])) {
                                    $data_prod_store['stock_f'] = $cant_total_f;
                                }
                                if (isset($quantities[1])) {
                                    $data_prod_store['stock_r'] = $cant_total_r;
                                }
                                if (isset($quantities[2])) {
                                    $data_prod_store['stock_cyo'] = $cant_total_cyo;
                                }
                                ProductStore::create($data_prod_store);
                            }
                        }
                    }

                    if (isset($pedido)) {
                        $ped_producto = PedidoProductos::where('pedido_id', $pedido->id)->where('product_id', $product->product_id)->first();
                        if ($ped_producto) {
                            $ped_producto->bultos_enviados   = $product->quantity;
                            $ped_producto->bultos_pendientes = $ped_producto->bultos - $product->quantity;
                            $ped_producto->save();
                        }
                    }

                    $countEgress = 0;
                    for ($i = 0; $i < count($quantities); $i++) {
                        if ($quantities[$i]['cant'] > 0) {
                            $invoice = 1;
                            if ($quantities[$i]['tipo'] == 'quantity_f') {
                                $circuito = 'F';
                                $egress   = $cant_total_f;
                                $quantity = $quantities[$i]['cant'];
                                $invoice  = 1;
                            }
                            if ($quantities[$i]['tipo'] == 'quantity_r') {
                                $circuito = 'R';
                                $egress   = $cant_total_r;
                                $quantity = $quantities[$i]['cant'];
                                $invoice  = ($explode[0] == 'TRASLADO' || $explode[0] == 'DEVOLUCION' || $explode[0] == 'DEVOLUCIONCLIENTE') ? 1 : 0;
                            }
                            if ($quantities[$i]['tipo'] == 'quantity_cyo') {
                                $circuito    = 'CyO';
                                $egress      = $cant_total_cyo;
                                $quantity    = $quantities[$i]['cant'];
                                $invoice     = 1;
                                $punto_venta = $product->producto->proveedor->punto_venta;
                            }
                            $countEgress += $egress;
                            MovementProduct::create([
                                'entidad_id'   => 1,
                                'entidad_tipo' => 'S',
                                'movement_id'  => $movement->id,
                                'product_id'   => $product->product_id,
                                'unit_package' => $product->unit_package,
                                'palet'        => $palet,
                                'invoice'      => $invoice,
                                'iibb'         => $product->iibb,
                                'unit_price'   => ($invoice) ? $product->unit_price : $product->neto,
                                'cost_fenovo'  => $product->costo_fenovo,
                                'tasiva'       => $product->tasiva,
                                'unit_type'    => $product->unit_type,
                                'entry'        => (!$es_traslado_a_deposito)?0:$egress,
                                'bultos'       => $quantity,
                                'egress'       => $egress,
                                'balance'      => (!$es_traslado_a_deposito)?($stock_inicial - $countEgress):$stock_inicial,
                                'punto_venta'  => $punto_venta,
                                'circuito'     => $circuito,
                                'deposito'     => $deposito,
                            ]);

                            if(!$deposito || !$a_deposito){
                                MovementProduct::create([
                                    'entidad_id'   => $insert_data['to'],
                                    'entidad_tipo' => $entidad_tipo,
                                    'movement_id'  => $movement->id,
                                    'product_id'   => $product->product_id,
                                    'unit_package' => $product->unit_package,
                                    'palet'        => $palet,
                                    'invoice'      => $invoice,
                                    'bultos'       => $quantity,
                                    'cost_fenovo'  => $product->costo_fenovo,
                                    'entry'        => $egress,
                                    'unit_price'   => ($invoice) ? $product->unit_price : $product->neto,
                                    'tasiva'       => $product->tasiva,
                                    'unit_type'    => $product->unit_type,
                                    'egress'       => 0,
                                    'balance'      => $stock_inicial_store + $countEgress,
                                    'punto_venta'  => $punto_venta,
                                    'circuito'     => $circuito,
                                    'deposito'     => $a_deposito,
                                ]);
                            }
                        }
                    }
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
            $id          = $request->input('id');
            $mp          = MovementProduct::where('id', $id)->where('product_id', $request->input('product_id'))->first();
            $mp->invoice = !$mp->invoice;
            $mp->save();
            return new JsonResponse(['msj' => 'Facturación cambiada', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function pendienteMotivoDestroy(Request $request)
    {
        try {
            $list_id = $request->list_id;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.salidas.insertByAjaxDestroy', compact('list_id'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function pendienteDestroy(Request $request)
    {
        // Quien origina la novedad
        $user  = Auth::user()->name;
        $desde = Store::find(Auth::user()->store_active)->description;

        // Cantidad de Productos
        $items = SessionProduct::where('list_id', $request->list_id)->count();

        // Destino
        $cadena = explode('_', $request->list_id);
        if ($cadena[0] == 'VENTACLIENTE') {
            $destino = Customer::find($cadena[1])->razon_social;
        } else {
            $tienda  = Store::find($cadena[1]);
            $destino = str_pad($tienda->cod_fenovo, 3, 0, STR_PAD_LEFT) . ' - ' . $tienda->description;
        }

        $mensaje = 'Anulación de ' . $cadena[0] . ', con destino a ' . $destino . ' con ' . $items . ' producto/s cargados. ';
        $mensaje .= 'Motivo <<' . $request->motivo . '>> ';
        $mensaje .= ' Generado por ' . $user . ' desde  ' . $desde;

        Mail::to('sistemas.ftk@gmail.com')->send(new NovedadMail($mensaje));

        SessionProduct::where('list_id', $request->list_id)->delete();
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }

    public function cambiarPausaSalida(Request $request)
    {
        $existe_session_en_curso = SessionProduct::where('list_id', $request->list_id)->whereNull('pausado')->count();
        $productos_en_session    = SessionProduct::where('list_id', $request->list_id)->where('pausado', $request->id_pausado)->get();
        if ($existe_session_en_curso && !is_null($productos_en_session[0]->pausado)) {
            return new JsonResponse(
                [
                    'msj'  => 'Para cambiar la pausa debe cerrar o pausar la salida pendiente a la misma tienda de ésta. ',
                    'type' => 'error',
                ]
            );
        }
        $id_pausado = rand(1111111111, 9999999999);
        foreach ($productos_en_session as $ps) {
            $ps->pausado = (is_null($ps->pausado)) ? $id_pausado : null;
            $ps->save();
        }
        return new JsonResponse(
            [
                'msj'  => 'Se cambio el pausado a la salida. ',
                'type' => 'success',
            ]
        );
    }

    public function updateStockFactura()
    {
        $productos = Product::all();
        foreach ($productos as $p) {
            $p->stock_f = $p->stockParaActualizacion();
            $p->save();
        }
    }

    public function updateStock($code = false)
    {
        if ($code) {
            $products = Product::where('cod_fenovo', $code)->get();
        } else {
            $products = Product::all();
        }

        foreach ($products as $p) {

            // Obtengo los movimientos
            $movements_products = MovementProduct::where('movement_id', '>', 1200)
                ->where('product_id', $p->id)
                ->where('entidad_id', 1)
                ->orderBy('id', 'ASC')
                ->get();

            // Voy actualizando los stocks desde los mas viejos a los mas recientes
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

            // Obtengo el Stock de los movimientos
            $stock = MovementProduct::whereEntidadId(1)->whereProductId($p->id)->orderBy('id', 'DESC')->limit(1)->first()->balance;

            // Obtengo el coeficiente de Stock
            $parametro = Coeficiente::find($p->id);

            // Reviso los stocks y actualizo
            $producto          = Product::find($p->id);
            $producto->stock_f = $stock          * ($parametro->coeficiente / 100);
            $producto->stock_r = $stock - $stock * ($parametro->coeficiente / 100);
            $producto->save();
        }

        if ($code) {
            return  new JsonResponse(['msj' => 'Stock actualizado, Cod_Fenovo ' . $code]);
        }

        return  new JsonResponse(['msj' => 'Stocks actualizados ']);
    }

    public function updateJurisdiccion()
    {
        $invoices = Invoice::all();
        foreach ($invoices as $invoice) {
            $mov                   = Movement::where('id', $invoice->movement_id)->first();
            $store                 = $mov->To($mov->type, true);
            $juris                 = $this->getJurisdiccion($store->state);
            $invoice->jurisdiccion = $juris;
            $invoice->save();
        }
    }

    private function getJurisdiccion($loc)
    {
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

    public function previewCreateInvoice($movement_id)
    {
        return view('admin.movimientos.salidas.crear-invoice', compact('movement_id'));
    }

    public function cargarProductos(Request $request)
    {
        try {
            $movement              = Movement::where('id', $request->movement_id)->with('products_egress')->firstOrFail();
            $m_productos           = $movement->products_egress;
            $movement_id           = $movement->id;
            $mostrar_check_invoice = !(str_contains($movement->type, 'DEVOLUCION') || str_contains($movement->type, 'DEBITO'));
            return new JsonResponse([
                'type' => 'success',
                'html' => view(
                    'admin.movimientos.salidas.partials.table-pre-invoice-productos',
                    compact('m_productos', 'mostrar_check_invoice', 'movement_id')
                )->render(),
            ]);
        } catch (\Exception $e) {
            return  new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
