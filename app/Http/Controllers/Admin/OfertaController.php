<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SessionOferta;
use App\Models\Store;
use App\Repositories\OfertaRepository;
use App\Repositories\ProductRepository;
use App\Repositories\StoreRepository;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class OfertaController extends Controller
{
    private $ofertaRepository;

    public function __construct(
        OfertaRepository $ofertaRepository,
        ProductRepository $productRepository,
        StoreRepository $storeRepository
    ) {
        $this->ofertaRepository  = $ofertaRepository;
        $this->productRepository = $productRepository;
        $this->storeRepository   = $storeRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $oferta = SessionOferta::with('product')->get();
            return DataTables::of($oferta)
                ->addIndexColumn()

                ->addColumn('producto', function ($oferta) {
                    return ($oferta->product) ? $oferta->product->name : null;
                })
                ->editColumn('p1tienda', function ($oferta) {
                    return $oferta->p1tienda;
                })
                ->editColumn('fechadesde', function ($oferta) {
                    return date('d-m-Y', strtotime($oferta->fecha_desde));
                })
                ->editColumn('fechahasta', function ($oferta) {
                    return date('d-m-Y', strtotime($oferta->fecha_hasta));
                })
                ->addColumn('vincular', function ($oferta) {
                    return '<a href="' . route('oferta.vincular.tienda', ['id' => $oferta->id]) . '"> <i class="fa fa-link"></i> </a>';
                })
                ->addColumn('asociadas', function ($oferta) {
                    return count($oferta->stores);
                })
                ->addColumn('edit', function ($oferta) {
                    $ruta = route('product.edit',['id' => $oferta->product_id, 'oferta_id' => $oferta->id,'fecha_oferta' => $oferta->id])."#precios";
                    return '<a href="'. $ruta . '"> <i class="fa fa-edit"></i> </a>';
                })
                ->addColumn('destroy', function ($oferta) {
                    $ruta = 'destroy(' . $oferta->id . ",'" . route('oferta.destroy') . "')";
                    return '<a class="dropdown-item" href="javascript:void(0)" onclick="' . $ruta . '"> <i class="fa fa-trash"></i> </a>';
                })
                ->rawColumns(['p1tienda', 'fechadesde', 'fechahasta', 'vincular', 'asociadas', 'edit', 'destroy'])
                ->make(true);
        }
        return view('admin.ofertas.index');
    }

    public function add()
    {
        try {
            $oferta    = null;
            $productos = Product::where('active', '=', 1)->orderBy('name', 'asc')->get();
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
            SessionOferta::create($data);
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
        SessionOferta::find($request->id)->delete();
        return new JsonResponse(['msj' => 'Oferta eliminada ... ', 'type' => 'success']);
    }
    
    public function destroyReload(Request $request)
    {
        SessionOferta::find($request->id)->delete();
        return new JsonResponse(
            [
                'divOferta' => view('admin.products.oferta')->render(),
            ]
        );
    }

    public function vincularTienda(Request $request)
    {
        $oferta = $this->ofertaRepository->getOne($request->id);
        $stores = Store::where('store_type', 'T')->get();
        return view('admin.ofertas.vincular', compact('oferta', 'stores'));
    }

    public function vincularTiendaUpdate(Request $request)
    {
        $oferta = SessionOferta::find($request->id);
        $oferta->stores()->sync($request->get('stores'));

        return redirect()->route('oferta.index');
    }
}
