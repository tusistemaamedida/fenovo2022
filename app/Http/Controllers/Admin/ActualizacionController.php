<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ActualizMatrif1ViewExport;
use App\Exports\ActualizMatrif2ViewExport;
use App\Exports\ActualizViewExport;
use App\Exports\CabeExport;
use App\Exports\CabeEleExport;

use App\Http\Controllers\Controller;
use App\Models\HistorialActualizacion;
use App\Models\Panamas;
use App\Models\SessionPrices;
use App\Repositories\SessionPricesRepository;
use Illuminate\Http\JsonResponse;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class ActualizacionController extends Controller
{
    private $sessionPricesRepository;

    public function __construct(SessionPricesRepository $sessionPricesRepository)
    {
        $this->sessionPricesRepository = $sessionPricesRepository;
    }

    public function index(Request $request)
    {
        // $sessionPrices = SessionPrices::orderBy('fecha_actualizacion', 'desc')->first();
        // return $sessionPrices->product->product_price;

        if ($request->ajax()) {
            $sessionPrices = SessionPrices::orderBy('fecha_actualizacion', 'asc')->get();
            return Datatables::of($sessionPrices)
                ->addIndexColumn()
                ->addColumn('fecha_actualizacion', function ($sessionPrices) {
                    return date('d-m-Y', strtotime($sessionPrices->fecha_actualizacion));
                })
                ->addColumn('cod_fenovo', function ($sessionPrices) {
                    return ($sessionPrices->product) ? $sessionPrices->product->cod_fenovo : null;
                })
                ->addColumn('product', function ($sessionPrices) {
                    return ($sessionPrices->product) ? $sessionPrices->product->name : null;
                })
                ->addColumn('p1tienda', function ($sessionPrices) {
                    return ($sessionPrices->Product) ? number_format($sessionPrices->p1tienda, 2) : null;
                })
                ->addColumn('p2tienda', function ($sessionPrices) {
                    return ($sessionPrices->Product) ? number_format($sessionPrices->p2tienda, 2) : null;
                })
                ->addColumn('p1may', function ($sessionPrices) {
                    return ($sessionPrices->Product) ? number_format($sessionPrices->p1may, 2) : null;
                })
                ->addColumn('destroy', function ($sessionPrices) {
                    $ruta = 'destroy(' . $sessionPrices->id . ",'" . route('actualizacion.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['fecha_actualizacion', 'cod_fenovo', 'product', 'p1tienda', 'p2tienda', 'p1may', 'destroy'])
                ->make(true);
        }
        return view('admin.actualizaciones.index');
    }

    public function historial(Request $request)
    {
        // $historialPrices = HistorialActualizacion::orderBy('updated_at', 'desc')->get();
        // $historialPrices->product->name;

        if ($request->ajax()) {
            $historialPrices = HistorialActualizacion::orderBy('updated_at', 'desc')->get();
            return Datatables::of($historialPrices)
                ->addIndexColumn()
                ->addColumn('fecha_actualizacion', function ($historialPrices) {
                    return date('d-m-Y', strtotime($historialPrices->updated_at));
                })
                ->addColumn('cod_fenovo', function ($historialPrices) {
                    return ($historialPrices->product) ? $historialPrices->product->cod_fenovo : null;
                })
                ->addColumn('product', function ($historialPrices) {
                    return ($historialPrices->product) ? $historialPrices->product->name : null;
                })
                ->addColumn('p1tienda', function ($historialPrices) {
                    return ($historialPrices->Product) ? number_format($historialPrices->p1tienda, 2) : null;
                })
                ->addColumn('p2tienda', function ($historialPrices) {
                    return ($historialPrices->Product) ? number_format($historialPrices->p2tienda, 2) : null;
                })
                ->addColumn('p1may', function ($historialPrices) {
                    return ($historialPrices->Product) ? number_format($historialPrices->p1may, 2) : null;
                })
                ->rawColumns(['fecha_actualizacion', 'cod_fenovo', 'product', 'p1tienda', 'p2tienda', 'p1may'])
                ->make(true);
        }
        return view('admin.actualizaciones.historial');
    }

    public function add()
    {
    }

    public function store(Request $request)
    {
    }

    public function edit(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
        SessionPrices::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }

    public function exportToCsv(Request $request)
    {
        return Excel::download(new ActualizViewExport($request), 'actualiz.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportToCsvM1(Request $request)
    {
        return Excel::download(new ActualizMatrif1ViewExport($request), 'actualp1.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportToCsvM2(Request $request)
    {
        return Excel::download(new ActualizMatrif2ViewExport($request), 'actualp2.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportCabePed(Request $request){

        // $arr_elementos = [];
        // $panamas = Panamas::orderBy('orden','ASC')->get();
        // $i = 0;

        // foreach ($panamas as $panama) {
        //     $element         = new stdClass();

        //     if($panama->tipo == 'PAN'){
        //         $id_caja = 'PANAMA';
        //     }elseif($panama->tipo == 'FLE'){
        //         $id_caja = 'FLETE T';
        //     }else{
        //         $id_caja = $panama->tipo;
        //     }

        //     $cip             = (is_null($panama->cip))?'8889':$panama->cip;

        //     $element->ID_CLI = $panama->pto_vta;
        //     $element->NOMCLI = str_replace ( ',', '', $panama->client_name);
        //     $element->CUICLI = $panama->client_cuit;
        //     $element->IVACLI = $panama->client_iva_type;
        //     $element->IDCAJA = $id_caja;
        //     $element->NROCOM = $panama->orden;
        //     $element->FECHA  = Carbon::parse($panama->created_at)->format('d/m/Y');
        //     $element->HORA   = Carbon::parse($panama->created_at)->format('H:i');
        //     $element->FISCAL = $cip . '-' . str_pad($panama->orden, 8, '0', STR_PAD_LEFT);;
        //     $element->NETO_1 = $panama->neto105;
        //     $element->IVAA_1 = '0.0';//$panama->iva_neto105;
        //     $element->NETO_2 = $panama->neto21;
        //     $element->IVAA_2 = '0.0';//$panama->iva_neto21;
        //     $element->NOGRAV = '0.0';//$panama->totalIibb;
        //     $element->IIBB   = $panama->totalIibb;
        //     $element->TOTVTA = $panama->neto21 + $panama->neto105;//$panama->totalConIva;
        //     $element->PAGEFV = '0.0';
        //     $element->PAGTAR = '0.0';
        //     $element->PAGCTA = '0.0';
        //     $element->COSVTA = $panama->costo_fenovo_total;
        //     $element->MARBTO = '0.0';
        //     $element->DESCTO = '0.0';
        //     $element->RECARG = '0.0';
        //     $element->TOTFIS = '0.0';
        //     $element->TOTFIS = '0.0';
        //     $i++;
        //     array_push($arr_elementos, $element);
        // }

        // return $arr_elementos;

        $invoice = false;
        return Excel::download(new CabeExport($request,$invoice), 'CABE_PED.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

    public function exportCabeEle(Request $request){
        $invoice = true;
        return Excel::download(new CabeEleExport($request,$invoice), 'CABE_ELE.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv']);
    }

}
