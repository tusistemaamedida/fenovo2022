<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;
use App\Models\Movement;
use App\Models\MovementProduct;
use App\Models\Store;
use App\Repositories\SessionProductRepository;

use App\Repositories\InvoicesRepository;

class NotasCreditoController extends Controller
{
    private $invoiceRepository;
    private $sessionProductRepository;

    public function __construct(
        InvoicesRepository $invoiceRepository,
        SessionProductRepository $sessionProductRepository) {
        $this->invoiceRepository = $invoiceRepository;
        $this->sessionProductRepository = $sessionProductRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $arrTypes = ['DEVOLUCION'];
            $movement = Movement::all()->whereIn('type', $arrTypes)->sortByDesc('created_at');

            return DataTables::of($movement)
                ->addIndexColumn()
                ->addColumn('destino', function ($movement) {
                    return $movement->origenData($movement->type);
                })
                ->addColumn('comprobante_nc', function ($movement) {
                    if(isset($movement->invoice)) return $movement->invoice->voucher_number;
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
                    $links = '<a class="flex-button" href="' . route('nc.show', ['id' => $movement->id]) . '"> <i class="fa fa-eye"></i> </a>';
                    if ($movement->invoice && !is_null($movement->invoice->cae)) {
                        $links .= '<a class="flex-button" target="_blank" href="' . route('ver.fe', ['movment_id' => $movement->id]) . '"> <i class="fas fa-download"></i> </a>';
                    } else {
                        $ruta = "'".route('create.invoice', ['movment_id' => $movement->id])."'";
                        $links .= '<a class="flex-button"  href="javascript:void(0)" onclick="createInvoice('. $ruta .')"> <i class="fas fa-file-invoice"></i> </a>';
                    }
                    return $links;
                })
                ->rawColumns(['origen', 'date', 'type', 'acciones','comprobante_nc'])
                ->make(true);
        }
        return view('admin.movimientos.notas-credito.index');
    }

    public function add(){
        return view('admin.movimientos.notas-credito.add');
    }

    public function show(Request $request)
    {
        $movement = Movement::query()->where('id', $request->id)->with('movement_salida_products')->first();
        $store    = Store::find($movement->to);
        return view('admin.movimientos.notas-credito.show', compact('movement', 'store'));
    }

    public function searchVoucherNumber(Request $request)
    {
        $term        = $request->term ?: '';
        $valid_names = [];
        $invoices = $this->invoiceRepository->search($term);
        foreach ($invoices as $invoice) {
            $valid_names[] = ['id' => $invoice->voucher_number, 'text' => $invoice->voucher_number . ' [ '.$invoice->client_name.' ]'];
        }
        return new JsonResponse($valid_names);
    }

    public function storeNotaCredito(Request $request){
        try {
            $list_id                       = $request->input('session_list_id');
            $explode                       = explode('_', $list_id);
            $insert_data['type']           = $explode[0];
            $insert_data['to']             = $explode[1];
            $insert_data['date']           = now();
            $insert_data['from']           = 1;
            $insert_data['status']         = 'FINISHED';
            $insert_data['voucher_number'] = $request->input('voucher_number');

            $movement         = Movement::create($insert_data);
            $this->sessionProductRepository->deleteList($list_id);
            return redirect()->route('nc.add');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
