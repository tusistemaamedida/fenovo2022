<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FleteSetting;
use App\Models\Ruta;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FleteSettingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $flete = FleteSetting::orderBy('hasta', 'asc')->get();

            return Datatables::of($flete)
                ->addIndexColumn()
                ->addColumn('edit', function ($flete) {
                    $ruta = 'edit(' . $flete->id . ",'" . route('fletes.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($flete) {
                    $flete = 'destroy(' . $flete->id . ",'" . route('fletes.destroy') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $flete . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['edit', 'destroy'])
                ->make(true);
        }
        return view('admin.fletes.index');
    }

    public function add()
    {
        try {
            $flete = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.fletes.insertByAjax', compact('flete'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function store(Request $request)
    {
        try {
            $data           = $request->except(['_token']);
            $data['active'] = 1;
            FleteSetting::create($data);
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
            $flete = FleteSetting::find($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.fletes.insertByAjax', compact('flete'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data           = $request->all();
            $data['active'] = ($request->has('active')) ? 1 : 0;
            FleteSetting::find($request->flete_id)->update($data);
            $flete = FleteSetting::find($request->flete_id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.fletes.insertByAjax', compact('flete'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function destroy(Request $request)
    {
        Ruta::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
