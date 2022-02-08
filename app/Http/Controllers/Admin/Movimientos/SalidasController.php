<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;

use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;

use App\Repositories\SessionProductRepository;
use App\Repositories\StoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;

class SalidasController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;
    private $sessionProductRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        ProductRepository $productRepository,
        SessionProductRepository $sessionProductRepository
    ) {
        $this->productRepository        = $productRepository;
        $this->customerRepository       = $customerRepository;
        $this->storeRepository          = $storeRepository;
        $this->sessionProductRepository = $sessionProductRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $arrTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
            $movement = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('created_at');
            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('Y-m-d', strtotime($movement->date));
                })
                ->editColumn('type', function ($movement) {
                    return $movement->type;
                })
                ->editColumn('updated_at', function ($movement) {
                    return date('Y-m-d H:i:s', strtotime($movement->updated_at));
                })
                ->addColumn('edit', function ($movement) {
                    return '<a class="dropdown-item" href="' . route('salidas.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'type', 'edit'])
                ->make(true);
        }
        return view('admin.movimientos.salidas.index');
    }

    public function add()
    {
        return view('admin.movimientos.salidas.add');
    }

    public function show(Request $request)
    {
        $movement    = Movement::find($request->id);
        $movimientos = MovementProduct::where('movement_id', $request->id)->orderBy('created_at', 'desc')->get();
        return view('admin.movimientos.salidas.show', compact('movement', 'movimientos'));
    }

    public function getClienteSalida(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];

        if ($request->to_type == 'VENTACLIENTE') {
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
            $stock         = $product->stock();
            if (!$stock) {
                $disabled      = 'disabled';
                $text_no_stock = ' -- SIN STOCK --';
            }

            $valid_names[] = [
                'id'       => $product->id,
                'text'     => $product->name . ' [' . $stock . ' ' . $product->unit_type . ']' . $text_no_stock,
                'disabled' => $disabled,  ];
        }

        return Response::json($valid_names);
    }

    public function getSessionProducts(Request $request)
    {
        try {
            $session_products = $this->sessionProductRepository->getByListId($request->input('list_id'));
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.salidas.partials.form-table-products', compact('session_products'))->render(),
            ]);
        } catch (\Exception $e) {
            return Response::json(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function deleteSessionProduct(Request $request)
    {
        try {
            $session_products = $this->sessionProductRepository->delete($request->input('id'));
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return Response::json(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function getPresentaciones(Request $request)
    {
        try {
            if ($request->has('id') && $request->input('id') != '') {
                $product = $this->productRepository->getById($request->input('id'));
                if ($product) {
                    $stock_presentaciones = [];
                    $presentaciones       = explode(',', $product->unit_package);

                    for ($i = 0; $i < count($presentaciones); $i++) {
                        $bultos            = 0;
                        $bultos_en_session = 0;
                        $presentacion      = $presentaciones[$i];
                        $stock_en_session  = $this->sessionProductRepository->getCantidadTotalDeBultos($product->id, $presentacion);

                        $stock                                    = $product->stock($presentacion);
                        $stock_presentaciones[$i]['presentacion'] = $presentacion;
                        $stock_presentaciones[$i]['stock']        = $stock;
                        // los bultos que hay disponibles se calcula dividiendo el balance por el peso del bulto
                        $peso_por_bulto = $product->unit_weight * $presentacion;

                        if ($stock) {
                            $bultos = $stock / $peso_por_bulto;
                        }
                        if ($stock_en_session) {
                            $bultos -= $stock_en_session;
                        }
                        $stock_presentaciones[$i]['bultos'] = $bultos;
                    }
                    return new JsonResponse([
                        'type' => 'success',
                        'html' => view(
                            'admin.movimientos.salidas.partials.inserByAjax',
                            compact('stock_presentaciones', 'product', 'presentaciones')
                        )->render(),
                    ]);
                }
                return Response::json(['msj' => 'El producto no existe', 'type' => 'error']);
            }
            return Response::json(['msj' => 'Limpiando...', 'type' => 'clear']);
        } catch (\Exception $e) {
            return Response::json(['msj' => $e->getMessage(), 'type' => 'error']);
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
                return Response::json(['msj' => 'Ingrese el cliente o tienda según corresponda.', 'type' => 'error', 'index' => 'to']);
            }
            if (!$unidades || count($unidades) == 0) {
                return Response::json(['msj' => 'Ingrese una cantidad a enviar.', 'type' => 'error', 'index' => 'quantity']);
            }
            for ($i = 0; $i < count($unidades); $i++) {
                $unidad = $unidades[$i];
                if ($unidad['value'] == 0 || $unidad['value'] == '0') {
                    $count_unidades_cero++;
                }
            }
            if (count($unidades) == $count_unidades_cero) {
                return Response::json(['msj' => 'Ingrese una cantidad a enviar.', 'type' => 'error', 'index' => 'quantity']);
            }
            $insert_data = [];
            $product     = $this->productRepository->getByIdWith($product_id);
            switch ($to_type) {
                case 'VENTA':
                    $insert_data['unit_price'] = $product->product_price->plist0;
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
            $insert_data['store_id']   = 1;
            $insert_data['invoice']    = true;
            $insert_data['product_id'] = $product_id;
            for ($i = 0; $i < count($unidades); $i++) {
                $unidad   = $unidades[$i];
                $quantity = (float)$unidad['value'];
                if ($quantity > 0) {
                    $explode                     = explode('_', $unidad['name']);
                    $insert_data['unit_package'] = (int)$explode[1];
                    $stock_en_session            = $this->sessionProductRepository->getCantidadTotalDeBultos($product_id, $insert_data['unit_package']);
                    $insert_data['quantity']     = $quantity + $stock_en_session;
                    $this->sessionProductRepository->updateOrCreate($insert_data);
                }
            }
            return new JsonResponse(['type' => 'success', 'msj' => 'ok']);
        } catch (\Exception $e) {
            return Response::json(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function storeSalida(Request $request)
    {
        try {
            $list_id                       = $request->input('session_list_id');
            $explode                       = explode('_', $list_id);
            $insert_data['type']           = $explode[0];
            $insert_data['to']             = $explode[1];
            $insert_data['date']           = now();
            $insert_data['from']           = 1;
            $insert_data['voucher_number'] = $request->input('voucher_number');

            $movement         = Movement::create($insert_data);
            $session_products = $this->sessionProductRepository->getByListId($list_id);
            foreach ($session_products as $product) {
                // resta del balance de la store fenovo porque es salida
                $latest = MovementProduct::all()
                    ->where('store_id', 1)
                    ->where('product_id', $product->product_id)
                    ->where('unit_package', $product->unit_package)
                    ->sortByDesc('id')->first();

                $balance = ($latest) ? $latest->balance - $product->quantity : 0;
                MovementProduct::firstOrCreate([
                    'store_id'     => 1,
                    'movement_id'  => $movement->id,
                    'product_id'   => $product->product_id,
                    'unit_package' => $product->unit_package, ], [
                        'invoice'  => $product->invoice,
                        'entry'    => 0,
                        'egress'   => $product->quantity,
                        'balance'  => $balance,
                    ]);

                // Suma al balance de la store to
                $latest = MovementProduct::all()
                    ->where('store_id', $insert_data['to'])
                    ->where('product_id', $product->product_id)
                    ->where('unit_package', $product->unit_package)
                    ->sortByDesc('id')->first();

                $balance = ($latest) ? $latest->balance + $product->quantity : $product->quantity;
                MovementProduct::firstOrCreate([
                    'store_id' => $insert_data['to'],
                    'movement_id' => $movement->id,
                    'product_id' => $product->product_id,
                    'unit_package' => $product->unit_package], [
                        'invoice' => $product->invoice,
                        'entry' => $product->quantity,
                        'egress' => 0,
                        'balance' => $balance
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
            return Response::json(['msj' => 'Facturación cambiada', 'type' => 'success']);
        } catch (\Exception $e) {
            return Response::json(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
