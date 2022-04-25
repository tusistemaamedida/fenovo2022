<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NovedadMail;
use App\Models\ProductDescuento;
use App\Repositories\DescuentoRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class DescuentoController extends Controller
{
    private $descuentoRepository;

    public function __construct(DescuentoRepository $descuentoRepository)
    {
        $this->descuentoRepository = $descuentoRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $descuento = ProductDescuento::where('active', 1)->orderBy('codigo', 'asc')->get();
            return DataTables::of($descuento)
                ->addIndexColumn()
                ->addColumn('edit', function ($descuento) {
                    $ruta = 'edit(' . $descuento->id . ",'" . route('descuento.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($descuento) {
                    $ruta = 'destroy(' . $descuento->id . ",'" . route('descuento.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['edit', 'destroy'])
                ->make(true);
        }
        return view('admin.descuentos.index');
    }

    public function add()
    {
        try {
            $descuento = null;
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.descuentos.insertByAjax', compact('descuento'))->render(),
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
            ProductDescuento::create($data);

            Mail::to('novedades@frioteka.com')->bcc('cachoalbornoz@gmail.com')->send(new NovedadMail('descuento creado'));

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
            $descuento = $this->descuentoRepository->getOne($request->id);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.descuentos.insertByAjax', compact('descuento'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data           = $request->except(['_token', 'descuento_id']);
            $data['active'] = ($request->has('active')) ? 1 : 0;
            $this->descuentoRepository->fill($request->input('descuento_id'), $data);
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
        ProductDescuento::find($request->id)->update(['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'danger']);
    }
}
