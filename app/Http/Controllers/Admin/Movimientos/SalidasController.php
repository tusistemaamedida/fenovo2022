<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Exports\MovementsExport;
use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\SessionProduct;
use App\Models\Store;
use App\Repositories\CustomerRepository;
use App\Repositories\EnumRepository;

use App\Repositories\ProductRepository;

use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;
use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Maatwebsite\Excel\Facades\Excel;
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
            if (Auth::user()->rol() == 'superadmin' || Auth::user()->rol() == 'admin') {
                $movement = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('created_at');
            } else {
                $movement = Movement::where('from', Auth::user()->store_active)->whereIn('type', $arrTypes)->orderBy('created_at', 'DESC')->get();
            }
            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('Y-m-d', strtotime($movement->date));
                })
                ->editColumn('type', function ($movement) {
                    return $movement->type;
                })
                ->editColumn('factura_nro', function ($movement) {
                    if($movement->type == 'VENTA' || $movement->type == 'VENTACLIENTE'){
                        if($movement->invoice && !is_null($movement->invoice->cae)){
                            return '<a class="flex-button text-primary" data-toggle="tooltip" data-placement="top" title="Descargar factura" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> '.$movement->invoice->voucher_number.' </a>'; ;
                        }else{
                            return '<a class="flex-button"   href="' . route('create.invoice', ['movment_id' => $movement->id]) . '">Generar Factura </a>';
                        }
                    }
                })
                ->editColumn('updated_at', function ($movement) {
                    return date('Y-m-d H:i:s', strtotime($movement->updated_at));
                })
                ->addColumn('acciones', function ($movement) {
                    $links = '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Detalles de salida" href="' . route('salidas.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                    if($movement->type == 'VENTA' || $movement->type == 'VENTACLIENTE'){
                        if ($movement->invoice && !is_null($movement->invoice->cae)) {
                            $links .= '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Descargar factura" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> <i class="fas fa-download"></i> </a>';
                        } else {
                            $links .= '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Generar factura"  href="' . route('create.invoice', ['movment_id' => $movement->id]) . '"> <i class="fas fa-file-invoice"></i> </a>';
                        }
                    }
                    return $links;
                })
                ->rawColumns(['origen', 'date', 'type', 'acciones','factura_nro'])
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
                    return $pendiente::origenData($explode[0], $explode[1]);
                })
                ->addColumn('items', function ($pendiente) {
                    $count = count(SessionProduct::query()->where('list_id', $pendiente->list_id)->get());
                    return '<span class="badge badge-primary">' . $count . '</span>';
                })
                ->addColumn('destroy', function ($pendiente) {
                    $ruta = 'eliminarPendiente(' . $pendiente->id . ",'" . route('salidas.pendiente.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->addColumn('edit', function ($pendiente) {
                    return '<a href="' . route('salidas.pendiente.show', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-pencil-alt"></i> </a>';
                })
                ->addColumn('print', function ($pendiente) {
                    return '<a href="' . route('salidas.pendiente.print', ['list_id' => $pendiente->list_id]) . '"> <i class="fa fa-print"></i> </a>';
                })
                ->rawColumns(['actualizacion', 'items', 'destino', 'edit', 'destroy', 'print'])
                ->make(true);
        }
        return view('admin.movimientos.salidas.pendientes');
    }

    public function pendienteShow(Request $request)
    {
        $explode     = explode('_', $request->input('list_id'));
        $tipo        = $explode[0];
        $destino     = $this::origenData($tipo, $explode[1], true);
        $destinoName = $this::origenData($tipo, $explode[1]);
        return view('admin.movimientos.salidas.add', compact('tipo', 'destino', 'destinoName'));
    }

    public function menuPrint(Request $request)
    {
        $tiposalidas = $this->enumRepository->getType('salidas');
        return view('admin.movimientos.salidas.print.print', compact('tiposalidas'));
    }

    public function printEntreFechas(Request $request)
    {
        $desde    = $request->desde;
        $hasta    = $request->hasta;
        $arrTypes = ($request->tipo) ? [$request->tipo] : ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $salidas = Movement::query()
            ->whereIn('type', $arrTypes)
            ->orderBy('created_at', 'ASC')
            ->whereBetween(DB::raw('DATE(created_at)'), [$request->desde, $request->hasta])
            ->get()
            ->unique('voucher_number');

        $pdf = PDF::loadView('admin.movimientos.salidas.print.entreFechas', compact('salidas', 'desde', 'hasta'));
        return $pdf->stream('salidas_fechas.pdf');
    }

    public function exportEntreFechas(Request $request, Response $response)
    {
        return $movimientos = Movement::whereBetween(DB::raw('DATE(date)'), [$request['desde'], $request['hasta']])->get();

        return DB::table('movements as t1')
        ->join('movement_products as t2', 't2.movement_id', '=', 't1.id')
        ->select('t2.id', 't1.date', )
        ->orderBy('t1.created_at', 'ASC')
        ->whereBetween(DB::raw('DATE(t1.date)'), [$request['desde'], $request['hasta']])
        ->get();

        // return Excel::download(new MovementsExport($request), 'movement.xlsx');
    }

    public function pendientePrint(Request $request)
    {
        $session_products = SessionProduct::query()->where('list_id', $request->input('list_id'))->get();
        $explode          = explode('_', $request->input('list_id'));
        $tipo             = $explode[0];
        $destino          = $this::origenData($tipo, $explode[1], true);
        $pdf              = PDF::loadView('admin.movimientos.salidas.print.salidas-detalle', compact('session_products', 'destino'));
        return $pdf->stream('salidas.pdf');
    }

    public function add()
    {
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

        if ($request->to_type == 'VENTACLIENTE' || $request->to_type == 'DEVOLUCIONCLIENTE') {
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
        $valid_names = [];
        $products    = $this->productRepository->search($term);

        foreach ($products as $product) {
            $disabled      = '';
            $text_no_stock = '';
            $stock         = $product->stock(null, Auth::user()->store_active);
            if (!$stock) {
                $disabled      = 'disabled';
                $text_no_stock = ' -- SIN STOCK --';
            }

            $valid_names[] = [
                'id'       => $product->id,
                'text'     => $product->name . '' . $text_no_stock,
                'disabled' => $disabled,  ];
        }

        return  new JsonResponse($valid_names);
    }

    public function getSessionProducts(Request $request)
    {
        try {
            $session_products      = $this->sessionProductRepository->getByListId($request->input('list_id'));
            $mostrar_check_invoice = !(str_contains($request->input('list_id'), 'DEVOLUCION_'));
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
            return new JsonResponse([
                'flete' => $this->sessionProductRepository->getFlete($request->input('list_id')),
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
                $product          = $this->productRepository->getById($request->input('id'));
                $list_id          = $request->input('list_id');
                $mostrar_detalles = !(str_contains($list_id, 'DEVOLUCION_'));

                if ($product) {
                    $stock_presentaciones = [];
                    $presentaciones       = explode('|', $product->unit_package);
                    $stock_total          = $product->stock(null, Auth::user()->store_active);

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
                    return new JsonResponse([
                        'type' => 'success',
                        'html' => view(
                            'admin.movimientos.salidas.partials.inserByAjax',
                            compact('stock_presentaciones', 'product', 'presentaciones', 'stock_total', 'mostrar_detalles')
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
            switch ($to_type) {
                case 'DEVOLUCION':
                case 'VENTA':
                    $insert_data['unit_price'] = $product->product_price->plist0neto;
                    $insert_data['tasiva']     = $product->product_price->tasiva;
                    break;
                case 'TRASLADO':
                    $insert_data['unit_price'] = 0;
                    $insert_data['tasiva']     = 0;
                    break;
                case 'VENTACLIENTE':
                    $customer       = $this->customerRepository->getById($to);
                    $listAssociates = [
                        'L0' => $product->product_price->plist0,
                        'L1' => $product->product_price->plist1,
                        'L2' => $product->product_price->plist2,
                    ];
                    $insert_data['unit_price'] = $listAssociates[$customer->listprice_associate];
                    $insert_data['tasiva']     = $product->product_price->tasiva;
                    break;
            }

            $insert_data['list_id']    = $to_type . '_' . $to;
            $insert_data['store_id']   = Auth::user()->store_active;
            $insert_data['invoice']    = true;
            $insert_data['product_id'] = $product_id;
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
            $list_id                       = $request->input('session_list_id');
            $explode                       = explode('_', $list_id);
            $insert_data['type']           = $explode[0];
            $insert_data['to']             = $explode[1];
            $insert_data['date']           = now();
            $insert_data['from']           = $from;
            $insert_data['status']         = 'FINISHED';
            $insert_data['voucher_number'] = $request->input('voucher_number');
            $insert_data['flete']          = (float)$request->input('flete');

            $movement         = Movement::create($insert_data);
            $session_products = $this->sessionProductRepository->getByListId($list_id);
            foreach ($session_products as $product) {
                // resta del balance de la store fenovo porque es salida
                $latest = MovementProduct::all()
                    ->where('store_id', $from)
                    ->where('product_id', $product->product_id)
                    ->where('unit_package', $product->unit_package)
                    ->sortByDesc('id')->first();

                $balance = ($latest) ? $latest->balance - ($product->producto->unit_weight * $product->unit_package * $product->quantity) : 0;
                MovementProduct::firstOrCreate([
                    'store_id'       => $from,
                    'movement_id'    => $movement->id,
                    'product_id'     => $product->product_id,
                    'unit_package'   => $product->unit_package, ], [
                        'invoice'    => $product->invoice,
                        'unit_price' => $product->unit_price,
                        'tasiva'     => $product->tasiva,
                        'entry'      => 0,
                        'bultos'     => $product->quantity,
                        'egress'     => $product->producto->unit_weight * $product->unit_package * $product->quantity,
                        'balance'    => $balance,
                    ]);

                // Suma al balance de la store to
                $latest = MovementProduct::all()
                    ->where('store_id', $insert_data['to'])
                    ->where('product_id', $product->product_id)
                    ->where('unit_package', $product->unit_package)
                    ->sortByDesc('id')->first();

                $balance = ($latest) ? $latest->balance + ($product->producto->unit_weight * $product->unit_package * $product->quantity) : ($product->producto->unit_weight * $product->unit_package * $product->quantity);
                MovementProduct::firstOrCreate([
                    'store_id'       => $insert_data['to'],
                    'movement_id'    => $movement->id,
                    'product_id'     => $product->product_id,
                    'unit_package'   => $product->unit_package, ], [
                        'invoice'    => $product->invoice,
                        'bultos'     => $product->quantity,
                        'entry'      => $product->producto->unit_weight * $product->unit_package * $product->quantity,
                        'unit_price' => $product->unit_price,
                        'tasiva'     => $product->tasiva,
                        'egress'     => 0,
                        'balance'    => $balance,
                    ]);
            }
            $this->sessionProductRepository->deleteList($list_id);
            return redirect()->route('salidas.add');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function changeInvoiceProduct(Request $request)
    {
        try {
            $session_product          = $this->sessionProductRepository->getByListIdAndProduct($request->input('list_id'), $request->input('product_id'));
            $session_product->invoice = !$session_product->invoice;
            $session_product->save();
            return new JsonResponse(['msj' => 'Facturación cambiada', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function pendienteDestroy(Request $request)
    {
        SessionProduct::find($request->id)->delete();
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }
}
