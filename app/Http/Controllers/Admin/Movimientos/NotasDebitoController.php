<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Movement;

use App\Models\MovementProduct;
use App\Models\Store;
use App\Repositories\InvoicesRepository;
use App\Repositories\SessionProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class NotasDebitoController extends Controller
{
    private $invoiceRepository;
    private $sessionProductRepository;

    public function __construct(
        InvoicesRepository $invoiceRepository,
        SessionProductRepository $sessionProductRepository
    ) {
        $this->invoiceRepository        = $invoiceRepository;
        $this->sessionProductRepository = $sessionProductRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $arrTypes = ['DEBITO','DEBITOCLIENTE'];
            $movement = Movement::all()->where('from', \Auth::user()->store_active)->whereIn('type', $arrTypes)->sortByDesc('created_at');

            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->addColumn('comprobante_nd', function ($movement) {
                    if (isset($movement->invoice)) {
                        return $movement->invoice->voucher_number;
                    }
                    return '--';
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
                ->addColumn('acciones', function ($movement) {
                    $links = '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Ver Detalles de ND" href="' . route('nd.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                    if ($movement->invoice && !is_null($movement->invoice->cae)) {
                        $links .= '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Descargar Nota Débito" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> <i class="fas fa-download"></i> </a>';
                    } else {
                        $ruta = "'" . route('create.invoice', ['movment_id' => $movement->id]) . "'";
                        $links .= '<a class="flex-button" data-toggle="tooltip" data-placement="top" title="Generar Nota Débito" href="javascript:void(0)" onclick="createInvoice(' . $ruta . ')"> <i class="fas fa-file-invoice"></i> </a>';
                    }
                    return $links;
                })
                ->rawColumns(['origen', 'date', 'type', 'acciones', 'comprobante_nc'])
                ->make(true);
        }
        return view('admin.movimientos.notas-debito.index');
    }

    public function add()
    {
        $this->sessionProductRepository->deleteDebitos();
        return view('admin.movimientos.notas-debito.add');
    }

    public function storeNotaDebito(Request $request)
    {
        try {
            if ($request->input('voucher_number') != '' || !is_null($request->input('voucher_number'))) {
                $list_id                       = $request->input('session_list_id');
                $explode                       = explode('_', $list_id);

                $from = \Auth::user()->store_active;
                $count = Movement::where('from', $from)->whereIn('type', ['DEBITO', 'DEBITOCLIENTE'])->count();
                $orden = ($count)?$count+1:1;

                $insert_data['type']           = $explode[0];
                $insert_data['to']             = $explode[1];
                $insert_data['date']           = now();
                $insert_data['from']           = $from;
                $insert_data['orden']          = $orden;
                $insert_data['status']         = 'FINISHED';
                $insert_data['voucher_number'] = $request->input('voucher_number');

                $movement             = Movement::create($insert_data);
                $session_products     = $this->sessionProductRepository->getByListId($list_id);
                $entidad_tipo         = parent::getEntidadTipo($insert_data['type']);

                foreach ($session_products as $product) {
                    $cantidad = ($product->producto->unit_type == 'K') ? $product->producto->unit_weight * $product->unit_package * $product->quantity : $product->unit_package * $product->quantity;
                    $latest = MovementProduct::all()
                        ->where('entidad_id', $movement->to)
                        ->where('entidad_tipo', $entidad_tipo)
                        ->where('product_id', $product->product_id)
                        ->sortByDesc('id')
                        ->first();

                    $balance = ($latest) ? $latest->balance + $cantidad : $cantidad;

                    MovementProduct::firstOrCreate([
                        'entidad_id'     => $movement->to,
                        'entidad_tipo'   => $entidad_tipo,
                        'movement_id'    => $movement->id,
                        'product_id'     => $product->product_id,
                        'unit_package'   => $product->unit_package, ], [
                            'invoice'    => 1,
                            'unit_price' => $product->unit_price,
                            'tasiva'     => $product->tasiva,
                            'entry'      => 0,
                            'bultos'     => $product->quantity,
                            'egress'     => $cantidad,
                            'balance'    => $balance,
                        ]);

                    $latest = MovementProduct::all()
                        ->where('entidad_id', \Auth::user()->store_active)
                        ->where('entidad_tipo', 'S')
                        ->where('product_id', $product->product_id)
                        ->sortByDesc('id')->first();

                    $balance = ($latest) ? $latest->balance - $cantidad : $cantidad;
                    MovementProduct::firstOrCreate([
                        'entidad_id'     => \Auth::user()->store_active,
                        'entidad_tipo'   => 'S',
                        'movement_id'    => $movement->id,
                        'product_id'     => $product->product_id,
                        'unit_package'   => $product->unit_package, ], [
                            'invoice'    => 1,
                            'unit_price' => $product->unit_price,
                            'tasiva'     => $product->tasiva,
                            'entry'      => $cantidad,
                            'bultos'     => $product->quantity,
                            'egress'     => 0,
                            'balance'    => $balance,
                        ]);
                }

                $this->sessionProductRepository->deleteList($list_id);
                return redirect()->route('nd.add')->withInput();
            }
            $request->session()->flash('error', 'No selecciono ninguna Factura');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Request $request)
    {
        $movement = Movement::query()->where('id', $request->id)->with('movement_salida_products')->first();
        $store    = Store::find($movement->to);
        return view('admin.movimientos.notas-debito.show', compact('movement', 'store'));
    }
}
