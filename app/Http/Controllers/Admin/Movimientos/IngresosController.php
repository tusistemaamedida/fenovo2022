<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\MovementProductTemp;
use App\Models\MovementTemp;
use App\Models\Product;
use App\Models\Proveedor;
use App\Models\Store;
use App\Repositories\EnumRepository;
use App\Repositories\ProductRepository;
use App\Repositories\ProveedorRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class IngresosController extends Controller
{
    private $proveedorRepository;
    private $enumRepository;

    public function __construct(ProveedorRepository $proveedorRepository, ProductRepository $productRepository, EnumRepository $enumRepository)
    {
        $this->proveedorRepository = $proveedorRepository;
        $this->productRepository   = $productRepository;
        $this->enumRepository      = $enumRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $movement = MovementTemp::where('to', Auth::user()->store_active)->where('type', 'COMPRA')->whereStatus('CREATED')->with('movement_ingreso_products')->orderBy('date', 'DESC')->get();
            
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('id', function ($movement) {
                    $ruta = 'editData(' . $movement->id . ",'" . route('ingresos.editIngreso') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '">' . $movement->id . '</a>';
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . count($movement->movement_ingreso_products) . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('edit', function ($movement) {
                    return '<a href="' . route('ingresos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i></a>';
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => false]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->addColumn('borrar', function ($movement) {
                    $ruta = 'destroy(' . $movement->id . ",'" . route('ingresos.destroyTemp') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['id', 'origen', 'date', 'items', 'voucher', 'show', 'edit', 'borrar'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.index');
    }

    public function indexCerradas(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::where('to', Auth::user()->store_active)->where('type', 'COMPRA')->whereStatus('FINISHED')->with('movement_ingreso_products')->orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();
            
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'items', 'voucher', 'show'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexCerradas');
    }

    public function indexChequeadas(Request $request)
    {
        if ($request->ajax()) {
            $movement = Movement::where('to', Auth::user()->store_active)->where('type', 'COMPRA')->whereStatus('CHECKED')->with('movement_ingreso_products')->orderBy('date', 'DESC')->orderBy('id', 'DESC')->get();
            
            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . $movement->cantidad_ingresos() . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('ingresos.show', ['id' => $movement->id, 'is_cerrada' => true]) . '"> <i class="fa fa-eye"></i> </a>';
                })
                ->rawColumns(['origen', 'date', 'items', 'voucher', 'show'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexChequeadas');
    }

    public function add()
    {
        $proveedores = Proveedor::orderBy('name')->pluck('name', 'id');
        return view('admin.movimientos.ingresos.add', compact('proveedores'));
    }

    public function store(Request $request)
    {
        $data     = $request->all();
        $movement = MovementTemp::create($data);
        return redirect()->route('ingresos.edit', ['id' => $movement->id]);
    }

    public function edit(Request $request)
    {
        $movement    = MovementTemp::find($request->id);
        $productos   = $this->productRepository->getByProveedorIdPluck($movement->from);
        $proveedor   = Proveedor::find($movement->from);
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.edit', compact('movement', 'proveedor', 'productos', 'movimientos'));
    }

    public function editIngreso(Request $request)
    {
        try {
            $movement  = MovementTemp::find($request->id);
            $proveedor = Proveedor::find($movement->from);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjaxIngreso', compact('movement', 'proveedor'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateIngreso(Request $request)
    {
        try {
            MovementTemp::find($request->movement_id)->update($request->all());
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function editProduct(Request $request)
    {
        try {
            $product      = Product::find($request->id);
            $unit_package = explode('|', $product->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.insertByAjax', compact('product', 'unit_package'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function updateProduct(Request $request)
    {
        try {
            $data['unit_package'] = implode('|', $request->unit_package);
            $data['unit_weight']  = $request->unit_weight;
            Product::find($request->product_id)->update($data);
            return new JsonResponse(['msj' => 'Actualización correcta !', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function close(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $request->id)->with('movement_ingreso_products')->first();

            $to    = Auth::user()->store_active;
            $count = Movement::where('to', $to)->where('type', 'COMPRA')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Guardo el nuevo movimiento
            $data['type']           = 'COMPRA';
            $data['subtype']        = $movement_temp->subtype;
            $data['to']             = $to;
            $data['date']           = $movement_temp->date;
            $data['from']           = $movement_temp->from;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = $movement_temp->flete;
            $data['observacion']    = $movement_temp->observacion;
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_new           = Movement::create($data);

            $hoy      = Carbon::parse(now())->format('Y-m-d');
            $circuito = '';
            if ($movement_temp->subtype == 'FACTURA') {
                $circuito = 'F';
            }
            if ($movement_temp->subtype == 'REMITO') {
                $circuito = 'R';
            }
            if ($movement_temp->subtype == 'CYO') {
                $circuito = 'CyO';
            }

            // Recorro el arreglo y voy guardando
            foreach ($movement_temp->movement_ingreso_products as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal();
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;

                MovementProduct::create([
                    'entidad_id'   => Auth::user()->store_active,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'circuito'     => $circuito,
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $movimiento['entry'],
                    'egress'       => $movimiento['egress'],
                    'balance'      => $movimiento['balance'],
                ]);

                $p = Product::where('id', $movimiento['product_id'])->first();
                if ($movimiento['cyo']) {
                    $p->stock_cyo = $p->stock_cyo + $movimiento['entry'];
                } elseif ($movimiento['invoice']) {
                    $p->stock_f = $p->stock_f + $movimiento['entry'];
                } else {
                    $p->stock_r = $p->stock_r + $movimiento['entry'];
                }
                $p->save();
            }

            // Elimino el Movimiento temporal
            MovementTemp::find($request->id)->delete();
            MovementProductTemp::whereMovementId($request->id)->delete();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.index');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    public function checkedCerrada(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            // Obtengo los datos del movimiento
            $movement = Movement::find($request->id);
            $movement->status = 'CHECKED';
            $movement->save();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.indexCerradas');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    

    public function show(Request $request)
    {
        $movement = (!$request->is_cerrada)
            ? MovementTemp::query()->where('id', $request->id)->with('movement_ingreso_products')->first()
            : Movement::query()->where('id', $request->id)->with('movement_ingreso_products')->first();

        $ajustes     = $this->enumRepository->getType('ajustes');
        $movimientos = $movement->movement_ingreso_products;

        return view('admin.movimientos.ingresos.show', compact('movement', 'movimientos', 'ajustes'));
    }

    public function destroy(Request $request)
    {
        Movement::find($request->id)->update(['status' => 'CANCELED']);
        return new JsonResponse(
            [
                'msj'  => 'Eliminado ... ',
                'type' => 'success',
            ]
        );
    }

    public function destroyTemp(Request $request)
    {
        MovementTemp::find($request->id)->delete();
        return new JsonResponse(
            ['msj'     => 'Eliminado ... ',
                'type' => 'success', ]
        );
    }
    public function getProveedorIngreso(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];

        $proveedors = $this->proveedorRepository->search($term);
        foreach ($proveedors as $proveedor) {
            $valid_names[] = ['id' => $proveedor->id, 'text' => $proveedor->displayName()];
        }

        return new JsonResponse($valid_names);
    }
    public function indexAjustarStock(Request $request)
    {
        if ($request->ajax()) {
            $query1   = MovementTemp::whereType('AJUSTE')->orderBy('date', 'DESC')->get();
            $query2   = Movement::whereType('AJUSTE')->whereColumn('from', '!=', 'to')->orderBy('date', 'DESC')->get();
            $movement = $query1->merge($query2);

            return Datatables::of($movement)
                ->addIndexColumn()
                ->addColumn('origen', function ($movement) {
                    return $movement->From($movement->type);
                })
                ->addColumn('destino', function ($movement) {
                    return $movement->To($movement->type);
                })
                ->editColumn('date', function ($movement) {
                    return date('d-m-Y', strtotime($movement->date));
                })
                ->addColumn('items', function ($movement) {
                    return '<span class="badge badge-primary">' . count($movement->movement_ingreso_products) . '</span>';
                })
                ->addColumn('voucher', function ($movement) {
                    return  $movement->voucher_number;
                })
                ->addColumn('accion', function ($movement) {
                    return ($movement->status == 'FINISHED')
                    ? '<a href="' . route('ingresos.ajustarStockDepositos.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>'
                    : '<a href="' . route('ingresos.ajustarStockDepositos.edit', ['id' => $movement->id]) . '"> <i class="fa fa-pencil-alt"></i> </a>';
                })
                ->addColumn('borrar', function ($movement) {
                    $ruta = 'destroy(' . $movement->id . ",'" . route('ingresos.destroyTemp') . "')";
                    return ($movement->status == 'CREATED') ? '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>' : null;
                })

                ->rawColumns(['origen', 'destino', 'date', 'items', 'voucher', 'accion', 'borrar'])
                ->make(true);
        }
        return view('admin.movimientos.ingresos.indexAjustes');
    }
    public function ajustarStockDepositos(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();
            $number   = date('d') . date('m') . date('y') . date('H') . date('i');
            $movement = MovementTemp::create([
                'date'           => now(),
                'type'           => 'AJUSTE',
                'from'           => 0,
                'to'             => 0,
                'user_id'        => \Auth::user()->id,
                'status'         => 'CREATED',
                'voucher_number' => $number,
            ]);

            $voucher_number           = $number . '-' . $movement->id;
            $movement->voucher_number = $voucher_number;
            $movement->save();

            DB::commit();
            Schema::enableForeignKeyConstraints();
            return redirect()->route('ingresos.ajustarStockDepositos.edit', ['id' => $movement->id]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
    public function ajustarStockDepositosEdit(Request $request)
    {
        $movement    = MovementTemp::find($request->id);
        $productos   = Product::selectRaw('id, CONCAT(name," - ",cod_fenovo) as nombreCompleto')->orderBy('name')->pluck('nombreCompleto', 'id');
        $stores      = Store::orderBy('cod_fenovo', 'asc')->where('active', 1)->get();
        $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
        return view('admin.movimientos.ingresos.ajustar', compact('movement', 'productos', 'stores', 'movimientos'));
    }
    public function ajustarStockDepositosShow(Request $request)
    {
        $movement    = Movement::query()->where('id', $request->id)->with('movement_ingreso_products')->first();
        $movimientos = $movement->movement_ingreso_products;
        return view('admin.movimientos.ingresos.showAjustes', compact('movement', 'movimientos'));
    }
    public function ajustarStockStoreDetalle(Request $request)
    {
        try {
            $hoy = Carbon::parse(now())->format('Y-m-d');

            foreach ($request->datos as $movimiento) {
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, Auth::user()->store_active);
                $balance               = ($latest) ? $latest + $movimiento['entry'] : $movimiento['entry'];
                $movimiento['balance'] = $balance;

                $costo_fenovo = 0;
                $unit_price   = 0;

                MovementProductTemp::firstOrCreate(
                    [
                        'entidad_id'   => Auth::user()->store_active,
                        'movement_id'  => $movimiento['movement_id'],
                        'product_id'   => $movimiento['product_id'],
                        'tasiva'       => $product->product_price->tasiva,
                        'cost_fenovo'  => $costo_fenovo,
                        'unit_price'   => $unit_price,
                        'unit_package' => $movimiento['unit_package'],
                        'unit_type'    => $movimiento['unit_type'],
                        'invoice'      => $movimiento['invoice'],
                        'cyo'          => $movimiento['cyo'],
                    ],
                    $movimiento
                );
            }
            return new JsonResponse(['msj' => 'Guardado', 'type' => 'success']);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function getMovements(Request $request)
    {
        try {
            $movimientos = MovementProductTemp::where('movement_id', $request->id)->orderBy('created_at', 'asc')->get();
            return new JsonResponse([
                'data' => $movimientos,
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleConfirmAjuste', compact('movimientos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function check(Request $request)
    {
        try {
            $productId      = $request->productId;
            $producto       = Product::find($productId);
            $presentaciones = explode('|', $producto->unit_package);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.ingresos.detalleTemp', compact('producto', 'presentaciones'))->render(),

            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
    public function ajustarStockDepositosClose(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            $movement_id   = $request->id;
            $tiendaIngreso = $request->tiendaIngreso;
            $tiendaEgreso  = $request->tiendaEgreso;

            // Obtengo los datos del movimiento
            $movement_temp = MovementTemp::where('id', $movement_id)->with('movement_products')->first();

            $count = Movement::where('to', $tiendaIngreso)->where('type', 'AJUSTE')->count();
            $orden = ($count) ? $count + 1 : 1;

            // Guardo el nuevo movimiento
            $data['type']           = 'AJUSTE';
            $data['to']             = $tiendaIngreso;
            $data['from']           = $tiendaEgreso;
            $data['date']           = $movement_temp->date;
            $data['orden']          = $orden;
            $data['status']         = 'FINISHED';
            $data['voucher_number'] = $movement_temp->voucher_number;
            $data['flete']          = $movement_temp->flete;
            $data['observacion']    = 'AJUSTE ENTRE DEPOSITOS. DESDE ' . str_pad($tiendaEgreso, 3, '0', STR_PAD_LEFT) . ' HACIA ' . str_pad($tiendaIngreso, 3, '0', STR_PAD_LEFT);
            $data['user_id']        = \Auth::user()->id;
            $data['flete_invoice']  = 0;
            $movement_new           = Movement::create($data);

            $hoy = Carbon::parse(now())->format('Y-m-d');

            // Recorro el arreglo y voy guardando
            foreach ($movement_temp->movement_products as $movimiento) {
                $cantidad = $movimiento['entry'];

                // Ajustar tiendaEgreso
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, $tiendaEgreso);
                $balance               = $latest - $cantidad;
                $movimiento['balance'] = $balance;

                MovementProduct::create([
                    'entidad_id'   => $tiendaEgreso,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'cyo'          => $movimiento['cyo'],
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => 0,
                    'egress'       => $cantidad,
                    'balance'      => $movimiento['balance'],
                ]);

                // Ajustar tiendaIngreso
                $product               = Product::find($movimiento['product_id']);
                $latest                = $product->stockReal(null, $tiendaIngreso);
                $balance               = ($latest) ? $latest + $cantidad : $cantidad;
                $movimiento['balance'] = $balance;

                MovementProduct::create([
                    'entidad_id'   => $tiendaIngreso,
                    'movement_id'  => $movement_new->id,
                    'entidad_tipo' => 'S',
                    'product_id'   => $movimiento['product_id'],
                    'unit_package' => $movimiento['unit_package'],
                    'unit_type'    => $movimiento['unit_type'],
                    'tasiva'       => $movimiento['tasiva'],
                    'cost_fenovo'  => $movimiento['cost_fenovo'],
                    'unit_price'   => $movimiento['unit_price'],
                    'invoice'      => $movimiento['invoice'],
                    'cyo'          => $movimiento['cyo'],
                    'bultos'       => $movimiento['bultos'],
                    'entry'        => $cantidad,
                    'egress'       => 0,
                    'balance'      => $movimiento['balance'],
                ]);

                $p = Product::where('id', $movimiento['product_id'])->first();
                if ($movimiento['cyo']) {
                    $p->stock_cyo = $p->stock_cyo + $cantidad;
                } elseif ($movimiento['invoice']) {
                    $p->stock_f = $p->stock_f + $cantidad;
                } else {
                    $p->stock_r = $p->stock_r + $cantidad;
                }
                $p->save();
            }

            // Elimino el Movimiento temporal
            MovementTemp::find($request->id)->delete();
            MovementProductTemp::whereMovementId($request->id)->delete();

            DB::commit();
            Schema::enableForeignKeyConstraints();

            return redirect()->route('ingresos.ajustarStockIndex');
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            dd($e->getMessage());
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function ajustarIngresoItem(Request $request)
    {
        try {
            DB::beginTransaction();
            Schema::disableForeignKeyConstraints();

            $product  = Product::find($request->producto_id);

            if ($request->bultos_anterior < $request->bultos_actual) {
                $operacion = 'suma';
                $cantidad = $request->bultos_actual - $request->bultos_anterior;
            } else {
                $operacion  = 'resta';
                $cantidad   = $request->bultos_anterior - $request->bultos_actual ;
            }

            switch ($request->tipo) {
                case 'FACTURA':
                    $product->stock_f = ($operacion == 'suma') ? $product->stock_f + $cantidad : $product->stock_f - $cantidad;
                    break;
                case 'REMITO':
                    $product->stock_r = ($operacion == 'suma') ? $product->stock_r + $cantidad : $product->stock_r - $cantidad;
                    break;
                case 'CyO':
                    $product->stock_cyo = ($operacion == 'suma') ? $product->stock_cyo + $cantidad : $product->stock_cyo - $cantidad;
                    break;
            }
            

            $product->save();
            $stock = $product->stock_f + $product->stock_r + $product->stock_cyo;

            $from  = \Auth::user()->store_active;
            $count = Movement::where('from', $from)->where('type', 'AJUSTE')->count();
            $orden = ($count) ? $count + 1 : 1;


            // Inserta movimiento de Ajuste
            $insert_data                   = [];
            $insert_data['type']           = 'AJUSTE';
            $insert_data['to']             = Auth::user()->store_active;
            $insert_data['date']           = now();
            $insert_data['from']           = Auth::user()->store_active;
            $insert_data['status']         = 'FINISHED';
            $insert_data['orden']          = $orden;
            $insert_data['voucher_number'] = time();
            $insert_data['flete']          = 0;
            $insert_data['user_id']        = Auth::user()->id;
            $insert_data['observacion']    = $request->observacion;
            $movement                      = Movement::create($insert_data);

            // Inserta el Detalle del Ajuste
            $latest['movement_id']  = $movement->id;
            $latest['entidad_id']   = (Auth::user()->store_active) ? Auth::user()->store_active : 1;
            $latest['entidad_tipo'] = 'S';
            $latest['unit_package'] = 0;
            $latest['circuito']     = $request->tipo;
            $latest['unit_type']    = $product->unit_type;
            $latest['product_id']   = $request->product_id;
            $latest['entry']        = ($operacion == 'suma') ? $cantidad : 0;
            $latest['egress']       = ($operacion == 'resta') ? $cantidad : 0;
            $latest['bultos']       = $request->bultos;
            $latest['balance']      = $stock;
            MovementProduct::create($latest);

            DB::commit();
            Schema::enableForeignKeyConstraints();

            //
            return new JsonResponse([
                'html' => view('admin.movimientos.ingresos.show-detalle', compact('movimientos'))->render(),
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            Schema::enableForeignKeyConstraints();
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }
}
