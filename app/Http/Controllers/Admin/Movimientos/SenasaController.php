<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Senasa;
use App\Models\Panamas;
use App\Models\Vehiculo;
use App\Repositories\LocalidadRepository;
use App\Repositories\SenasaRepository;
use App\Repositories\VehiculoRepository;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SenasaController extends Controller
{
    private $senasaRepository;

    public function __construct(
        SenasaRepository $senasaRepository,
        VehiculoRepository $vehiculoRepository,
        LocalidadRepository $localidadRepository
    ) {
        $this->senasaRepository    = $senasaRepository;
        $this->vehiculoRepository  = $vehiculoRepository;
        $this->localidadRepository = $localidadRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $senasa = Senasa::all()->sortByDesc('id');
            return Datatables::of($senasa)
                ->addIndexColumn()
                ->editColumn('updated_at', function ($senasa) {
                    return date('Y-m-d H:i:s', strtotime($senasa->updated_at));
                })
                ->addColumn('vincular', function ($senasa) {
                    return '<a href="' . route('senasa.vincular', ['id' => $senasa->id]) . '"> <i class="fa fa-link"></i> </a>';
                })
                ->addColumn('desvincular', function ($senasa) {
                    return '<a href="' . route('senasa.desvincular', ['id' => $senasa->id]) . '"> <i class="fa fa-unlink"></i> </a>';
                })
                ->addColumn('print', function ($senasa) {
                    return '<a href="' . route('senasa.print', ['id' => $senasa->id]) . '"> <i class="fa fa-print"></i> </a>';
                })
                ->addColumn('edit', function ($senasa) {
                    $ruta = 'edit(' . $senasa->id . ",'" . route('senasa.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($senasa) {
                    $ruta = 'destroy(' . $senasa->id . ",'" . route('senasa.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['print', 'desvincular', 'vincular', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.movimientos.senasa.index');
    }

    public function add()
    {
        try {
            $senasa    = null;
            $vehiculos = $this->vehiculoRepository->getAll();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.senasa.insertByAjax', compact('senasa', 'vehiculos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->except(['_token']);
            $this->senasaRepository->create($data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function edit(Request $request)
    {
        try {
            $senasa    = Senasa::find($request->id);
            $vehiculos = $this->vehiculoRepository->getAll();
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.senasa.insertByAjax', compact('senasa', 'vehiculos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->except(['_token', 'senasa_id']);
            $this->senasaRepository->update($request->input('senasa_id'), $data);
            return new JsonResponse([
                'msj'  => 'Actualización correcta !',
                'type' => 'success',
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        Senasa::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'danger']);
    }

    public function vincular(Request $request)
    {
        $senasa     = Senasa::find($request->id);
        $arrayTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movements  = Movement::doesntHave('senasa')->whereIn('type', $arrayTypes)->orderBy('id', 'desc')->limit(100)->get();

        return view('admin.movimientos.senasa.vincular', compact('senasa', 'movements'));
    }

    public function desvincular(Request $request)
    {
        $senasa     = Senasa::find($request->id);
        $arrayTypes = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $movements  = Movement::with('senasa')->whereRelation('senasa', 'senasa.id', '=', $request->id)->get();

        return view('admin.movimientos.senasa.desvincular', compact('senasa', 'movements'));
    }

    public function vincularStore(Request $request)
    {
        $senasa = Senasa::find($request->id);
        $tipo_flete = 'FLETE T';
        $vehiculo = Vehiculo::where('patente',$senasa->patente_nro)->first();

        if($vehiculo->propio){
            $tipo_flete = 'FLETE P';
        }

        $movements = $request->get('movements');
        $senasa->movements()->sync($movements);
        if($movements){
            foreach ($movements as $m) {
                $panama = Panamas::where('movement_id',$m)->where('tipo','!=','PAN')->first();
                if(isset($panama)){
                    $panama->tipo = $tipo_flete;
                    $panama->save();
                }
            }
        }

        return redirect()->route('senasa.index');
    }

    public function print(Request $request)
    {
        $senasa      = Senasa::find($request->id);
        $movimientos = $senasa->productos_senasa($request->id);
        $pdf         = PDF::loadView('admin.movimientos.senasa.print', compact('senasa', 'movimientos'));
        return $pdf->stream('senasa.pdf');
    }
}
