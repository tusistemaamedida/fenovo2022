<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductOferta;
use App\Repositories\OfertaRepository;
use App\Repositories\ProductRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfertaController extends Controller
{
    private $ofertaRepository;

    public function __construct(OfertaRepository $ofertaRepository, ProductRepository $productRepository)
    {
        $this->ofertaRepository  = $ofertaRepository;
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $oferta = ProductOferta::with('product')->get();
            return DataTables::of($oferta)
                ->addIndexColumn()

                ->addColumn('producto', function ($oferta) {
                    return ($oferta->product) ? $oferta->product->name : null;
                })
                ->editColumn('fechadesde', function ($oferta) {
                    return date('d-m-Y', strtotime($oferta->fechadesde));
                })
                ->editColumn('fechahasta', function ($oferta) {
                    return date('d-m-Y', strtotime($oferta->fechahasta));
                })
                ->addColumn('edit', function ($oferta) {
                    $ruta = 'edit(' . $oferta->id . ",'" . route('oferta.edit') . "')";
                    return '<a href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($oferta) {
                    $ruta = 'destroy(' . $oferta->id . ",'" . route('oferta.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['fechadesde', 'fechahasta', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.ofertas.index');
    }

    public function add()
    {
        try {
            $oferta    = null;
            $productos = $this->productRepository->all()->where('active', '=', 1);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.ofertas.insertByAjax', compact('oferta', 'productos'))->render(),
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
            ProductOferta::create($data);
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
            $oferta    = $this->ofertaRepository->getOne($request->id);
            $productos = $this->productRepository->all()->where('active', '=', 1);
            return new JsonResponse([
                'type' => 'success',
                'html' => view('admin.ofertas.insertByAjax', compact('oferta', 'productos'))->render(),
            ]);
        } catch (\Exception $e) {
            return new JsonResponse(['msj' => $e->getMessage(), 'type' => 'error']);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->except(['_token', 'oferta_id']);
            $this->ofertaRepository->update($request->input('oferta_id'), $data);
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
        ProductOferta::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
