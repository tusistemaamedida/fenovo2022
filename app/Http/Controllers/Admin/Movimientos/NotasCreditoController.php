<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;

use App\Models\Invoice;
use App\Models\Movement;

use App\Models\MovementProduct;
use App\Models\Product;
use App\Models\Store;
use App\Repositories\InvoicesRepository;
use App\Repositories\SessionProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class NotasCreditoController extends Controller
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
        $arrTypes = ['DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $movement = Movement::where('from', \Auth::user()->store_active)->whereIn('type', $arrTypes)->orderBy('created_at','DESC')->get();
        if ($request->ajax()) {
            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->addColumn('comprobante_nc', function ($movement) {
                    if (!is_null($movement->invoice_fenovo())) {
                        return $movement->invoice_fenovo()->voucher_number;
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
                ->addColumn('show', function ($movement) {
                    return '<a href="' . route('nc.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                })

                ->addColumn('nc', function ($movement) {
                    if ($movement->invoice_fenovo() && !is_null($movement->invoice_fenovo()->cae)) {
                        $link = '<a target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> <i class="fas fa-download"></i> </a>';
                    } else {
                        $ruta = "'" . route('create.invoice', ['movment_id' => $movement->id]) . "'";
                        $link = '<a  href="javascript:void(0)" onclick="createInvoice(' . $ruta . ')"> <i class="fas fa-file-invoice"></i> </a>';
                    }
                    return $link;
                })

                ->rawColumns(['origen', 'date', 'type', 'show', 'nc', 'comprobante_nc'])
                ->make(true);
        }
        return view('admin.movimientos.notas-credito.index');
    }

    public function add()
    {
        $storesNaves = Store::where('store_type', 'N')->get(); //Los depositos los tenemos como N = Nave
        $this->sessionProductRepository->deleteDevoluciones();
        return view('admin.movimientos.notas-credito.add', compact('storesNaves'));
    }

    public function show(Request $request)
    {
        $movement = Movement::query()->where('id', $request->id)->with('movement_salida_products')->first();
        $store    = Store::find($movement->to);
        return view('admin.movimientos.notas-credito.show', compact('movement', 'store'));
    }

    public function searchVoucherNumber(Request $request)
    {
        $term         = $request->term ?: '';
        $valid_names  = [];
        $invoices     = $this->invoiceRepository->search($term);
        $tipo_factura = '';
        foreach ($invoices as $invoice) {
            if ($invoice->tipoFactura->afip_id == 3) {
                $tipo_factura = 'NCA';
            } elseif ($invoice->tipoFactura->afip_id == 2) {
                $tipo_factura = 'NDA';
            } elseif ($invoice->tipoFactura->afip_id == 1) {
                $tipo_factura = 'FCA';
            }

            $valid_names[] = ['id' => $invoice->voucher_number,
                'text'             => $tipo_factura . $invoice->voucher_number . ' [ ' . substr($invoice->client_name, 0, 15) . ' ]', ];
        }
        return new JsonResponse($valid_names);
    }

    public function validateVoucherTo(Request $request)
    {
        $to             = $request->input('to');
        $voucher_number = $request->input('voucher_number');
        $invoice        = Invoice::where('voucher_number', $voucher_number)->first();
        if ($invoice) {
            $movement_relacionado = Movement::where('id', $invoice->movement_id)->first();

            if ($movement_relacionado && $movement_relacionado->to == $to) {
                return new JsonResponse(['type' => 'success']);
            }
            return new JsonResponse(['type' => 'error', 'msj' => 'El número de facura no corresponde a la tienda seleccionada']);
        }
        return new JsonResponse(['type' => 'error', 'msj' => 'El número de facura no corresponde a la tienda seleccionada']);
    }

    public function storeNotaCredito(Request $request)
    {
        try {
            if ($request->input('voucher_number') != '' || !is_null($request->input('voucher_number'))) {
                $list_id  = $request->input('session_list_id');
                $explode  = explode('_', $list_id);
                $deposito = (int)$request->input('deposito');

                $from  = \Auth::user()->store_active;
                $count = Movement::where('from', $from)->whereIn('type', ['DEVOLUCION', 'DEVOLUCIONCLIENTE'])->count();
                $orden = ($count) ? $count + 1 : 1;

                $store = Store::where('id', $explode[1])->first();
                $label = '';
                if ($store) {
                    $label .= $store->razon_social . ' ' . $store->description;
                }
                $insert_data['observacion']    = 'NC a ' . $label;
                $insert_data['type']           = $explode[0];
                $insert_data['to']             = $explode[1]; // $explode[1]; Se cambio a deposito reclamos
                $insert_data['date']           = now();
                $insert_data['from']           = $from;
                $insert_data['orden']          = $orden;
                $insert_data['status']         = 'FINISHED';
                $insert_data['voucher_number'] = $request->input('voucher_number');
                $movement                      = Movement::create($insert_data);

                $session_products = $this->sessionProductRepository->getByListId($list_id);
                $entidad_tipo     = parent::getEntidadTipo($insert_data['type']);

                foreach ($session_products as $product) {
                    $cantidad = ($product->producto->unit_type == 'K') ? $product->producto->unit_weight * $product->unit_package * $product->quantity : $product->unit_package * $product->quantity;

                    // busco el balance del producto y el TO del movimento de salida para restarle la cantidad devuelta
                    $latest = MovementProduct::all()
                        ->where('entidad_id', $movement->to)
                        ->where('entidad_tipo', $entidad_tipo)
                        ->where('product_id', $product->product_id)
                        ->sortByDesc('id')
                        ->first();

                    $balance = ($latest) ? $latest->balance - $cantidad : $cantidad;

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

                    // Revisar si la DEVOLUCION se dirige DEPOSITO NAVE
                    if ($deposito == 1) {
                        $producto = Product::find($product->producto->id);
                        $producto->stock_f += $cantidad;
                        $producto->save();
                        $balance = $product->producto->stockReal() + $cantidad;
                    } else {
                        // A otros :: Depósito Reclamos
                        $latest = MovementProduct::all()
                        ->where('entidad_id', $deposito)
                        ->where('entidad_tipo', 'S')
                        ->where('product_id', $product->product_id)
                        ->sortByDesc('id')->first();
                        $balance = ($latest) ? $latest->balance + $cantidad : $cantidad;
                    }

                    MovementProduct::firstOrCreate([
                        'entidad_id'     => $deposito,
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
                return redirect()->route('nc.add')->withInput();
            }
            $request->session()->flash('error', 'No selecciono ninguna Factura');
            return redirect()->back()->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
