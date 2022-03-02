<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\Senasa;
use App\Repositories\SenasaRepository;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SenasaController extends Controller
{
    private $senasaRepository;

    public function __construct(SenasaRepository $senasaRepository)
    {
        $this->senasaRepository = $senasaRepository;
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
                ->addColumn('print', function ($senasa) {
                    return '<a href="' . route('senasa.print', ['id' => $senasa->id]) . '"> <i class="fa fa-print"></i> </a>';
                })
                ->addColumn('edit', function ($senasa) {
                    $ruta = 'edit(' . $senasa->id . ",'" . route('senasa.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->rawColumns(['print', 'edit', 'vincular'])
                ->make(true);
        }
        return view('admin.movimientos.senasa.index');
    }

    public function add()
    {
        try {
            $senasa = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.senasa.insertByAjax', compact('senasa'))->render(),
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
            $senasa = Senasa::find($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.movimientos.senasa.insertByAjax', compact('senasa'))->render(),
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

    public function vincular(Request $request)
    {
        $senasa    = Senasa::find($request->id);
        $movements = Movement::where('TYPE', '!=', 'COMPRA')->orderBy('id', 'desc')->limit(100)->get();
        return view('admin.movimientos.senasa.vincular', compact('senasa', 'movements'));
    }

    public function vincularStore(Request $request)
    {
        $senasa = Senasa::find($request->id);
        $senasa->movements()->sync($request->get('movements'));
        $notification = [
            'message'    => 'Relacion actualizada !',
            'alert-type' => 'info',
        ];

        return redirect()->route('senasa.index')->with($notification);
    }

    public function print(Request $request)
    {
        $senasa      = Senasa::find($request->id);
        $movimientos = $senasa->productos_senasa($request->id);
        $pdf         = PDF::loadView('admin.movimientos.senasa.print', compact('senasa', 'movimientos'));
        return $pdf->stream('senasa.pdf');
    }
}
