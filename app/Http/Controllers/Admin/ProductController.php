<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

use App\Repositories\ProductRepository;
use App\Repositories\AlicuotaTypeRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProducTypeRepository;
use App\Repositories\ProveedorRepository;
use App\Repositories\SenasaDefinitionRepository;
use App\Repositories\ProductPriceRepository;
use App\Http\Requests\Products\CalculatePrices;
use App\Http\Requests\Products\AddProduct;

class ProductController extends Controller
{
    private $productRepository;
    private $productPriceRepository;
    private $alicuotaTypeRepository;
    private $productCategoryRepository;
    private $productTypeRepository;
    private $proveedorRepository;
    private $senasaDefinitionRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductPriceRepository $productPriceRepository,
        ProductCategoryRepository $productCategoryRepository,
        ProducTypeRepository $productTypeRepository,
        ProveedorRepository $proveedorRepository,
        SenasaDefinitionRepository $senasaDefinitionRepository,
        AlicuotaTypeRepository $alicuotaTypeRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productPriceRepository = $productPriceRepository;
        $this->alicuotaTypeRepository = $alicuotaTypeRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->proveedorRepository = $proveedorRepository;
        $this->senasaDefinitionRepository = $senasaDefinitionRepository;
    }

    public function list(Request $request){

        if ($request->ajax()) {
            $productos = $this->productRepository->all();
            return Datatables::of($productos)
                ->addIndexColumn()
                ->addColumn('costo', function ($product) {
                    return '$'.$product->product_price->costfenovo;
                })
                ->addColumn('precios_fenovo', function ($product) {
                    return 'L0: $'.$product->product_price->plist0iva.'<br> L1: $'. $product->product_price->plist1.'<br> L2: $'.$product->product_price->plist2;
                })
                ->addColumn('precios_tiendas', function ($product) {
                    return 'PT1: $'.$product->product_price->p1tienda.'<br> PT2: $'.$product->product_price->p2tienda;
                })
                ->addColumn('proveedor', function ($product) {
                    return $product->proveedor->name;
                })
                ->addColumn('acciones', function ($producto) {
                    $ruta = "destroy(" . $producto->id . ",'" . route('proveedors.destroy') . "')";
                    $actions = '<a class="dropdown-item" href="'. route('proveedors.edit', ['id' => $producto->id]) . '"><i class="fa fa-edit"></i> Editar</a>';
                    $actions .= '<a class="dropdown-item confirm-delete" title="Delete" href="javascript:void(0)" onclick="' . $ruta . '"><i class="fa fa-trash"></i>Eliminar</a></div>';

                    return $actions;
                })
                ->rawColumns(['costo','precios_fenovo','precios_tiendas','acciones'])
                ->make(true);
        }

        return view('admin.products.list');
    }

    public function add()
    {
        $alicuotas = $this->alicuotaTypeRepository->get('value', 'DESC');
        $senasaDefinitions = $this->senasaDefinitionRepository->get('product_name', 'DESC');
        $categories = $this->productCategoryRepository->getActives('name', 'ASC');
        $types = $this->productTypeRepository->getActives('name', 'ASC');
        $proveedores = $this->proveedorRepository->getActives('name', 'ASC');
        return view('admin.products.add', compact('alicuotas', 'categories', 'types', 'proveedores', 'senasaDefinitions'));
    }

    public function store(AddProduct $request){
       try {
            $data = $request->all();
            $preciosCalculados =  $this->calcularPrecios($request);
            $data = array_merge($data, $preciosCalculados);
            $producto_nuevo = $this->productRepository->create($data);
            $data['product_id'] = $producto_nuevo->id;
            $this->productPriceRepository->create($data);
            return new JsonResponse(['type' => 'success','msj' =>'Producto agregado correctamente!']);
       } catch (\Exception $e) {
            return new JsonResponse(['type' => 'error','msj' => $e->getMessage()]);
       }
    }

    public function validateCode(Request $request)
    {
        $data = $request->all();
        if ($data['cod_fenovo'] == '') return new JsonResponse(['msj' => 'Ingrese un Código Fenovo', 'type' => 'error']);
        if ($this->productRepository->existCode($data['cod_fenovo'])) return new JsonResponse(['msj' => 'El Código Fenovo ingresado ya existe', 'type' => 'error']);
        return new JsonResponse(['msj' => 'Ok', 'type' => 'success']);
    }

    public function calculateProductPrices(CalculatePrices $request){
        $array_prices = $this->calcularPrecios($request);
        if($request->ajax()){
            return new JsonResponse($array_prices);
        }
        return $array_prices;
    }

    private function calcularPrecios($request){
        try {
            $plistproveedor = ($request->has('plistproveedor')) ? $request->input('plistproveedor') : 0;
            $descproveedor  = ($request->has('descproveedor')) ? $request->input('descproveedor') : 0;

            $mupfenovo  = ($request->has('mupfenovo')) ? $request->input('mupfenovo') : 0;
            $contribution_fund  = ($request->has('contribution_fund')) ? $request->input('contribution_fund') : 0;

            $tasiva    = ($request->has('tasiva')) ? $request->input('tasiva') * 100 : 21;
            $muplist1  = ($request->has('muplist1')) ? $request->input('muplist1') : 0;
            $muplist2  = ($request->has('muplist2')) ? $request->input('muplist2') : 0;
            $p1tienda  = ($request->has('p1tienda')) ? $request->input('p1tienda') : 0;
            $descp1  = ($request->has('descp1')) ? $request->input('descp1') : 0;
            $p2tienda  = ($request->has('p2tienda')) ? $request->input('p2tienda') : 0;
            $descp2  = ($request->has('descp2')) ? $request->input('descp2') : 0;

            $costFenovo = $this->costFenovo($plistproveedor, $descproveedor);
            $plist0Neto = $this->plist0Neto($costFenovo, $mupfenovo, $contribution_fund);
            $plist0Iva  = $this->plist0Iva($plist0Neto, $tasiva);
            $plist1     = $this->plist1($plist0Iva, $muplist1);
            $comlista1  = $this->comlista1($plist0Iva, $plist1, $tasiva);
            $plist2     = $this->plist2($plist0Iva, $muplist2);
            $comlista2  = $this->comlista2($plist0Iva, $plist2, $tasiva);
            $mup1       = $this->mup1($plist0Iva, $p1tienda);
            $p1may      = $this->p1may($p1tienda, $descp1);
            $mupp1may   = $this->mupp1may($p1may, $plist0Iva);
            $mup2       = $this->mup2($plist0Iva, $p2tienda);
            $p2may      = $this->p2may($p2tienda, $descp2);
            $mupp2may   = $this->mupp2may($p2may, $plist0Iva);

            return [
                'type'=>'success',
                'msj'=> 'ok',
                'costfenovo' => $costFenovo,
                'plist0neto' => $plist0Neto,
                'plist0iva' => $plist0Iva,
                'plist1' => $plist1,
                'comlista1' => $comlista1,
                'plist2' => $plist2,
                'comlista2' => $comlista2,
                'mup1' => $mup1,
                'p1may' => $p1may,
                'mupp1may' => $mupp1may,
                'mup2' => $mup2,
                'p2may' => $p2may,
                'mupp2may' => $mupp2may,
            ];
        } catch (\Exception $th) {
            return ['type'=>'error','msj'=> $th->getMessage()];
        }
    }

    private function mupp2may($p2may, $plist0Iva)
    {
        try {
            return round(($p2may / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function p2may($p2tienda, $descp2)
    {
        try {
            return round($p2tienda - $p2tienda * ($descp2 / 100), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function mup2($plist0Iva, $p2tienda)
    {
        try {
            return round(($p2tienda / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function mupp1may($p1may, $plist0Iva)
    {
        try {
            return round(($p1may / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function p1may($p1tienda, $descp1)
    {
        try {
            return round($p1tienda - $p1tienda * ($descp1 / 100), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function mup1($plist0Iva, $p1tienda)
    {
        try {
            return round(($p1tienda / $plist0Iva - 1) * 100, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function costFenovo($plistproveedor, $descproveedor)
    {
        try {
            return round($plistproveedor - $plistproveedor * ($descproveedor / 100), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function plist0Neto($costFenovo, $mupfenovo, $contribution_fund)
    {
        try {
            return round($costFenovo * ($mupfenovo / 100 + 1) * ($contribution_fund / 100 + 1), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function plist0Iva($plist0Neto, $tasiva)
    {
        try {
            return round($plist0Neto * ($tasiva / 100 + 1), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function plist1($plist0Iva, $muplist1)
    {
        try {
            return round($plist0Iva * ($muplist1 / 100 + 1), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function comlista1($plist0Iva, $plist1, $tasiva)
    {
        try {
            return round((($plist1 - $plist0Iva) / ($tasiva / 100 + 1) * 100) / $plist1, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function plist2($plist0Iva, $muplist2)
    {
        try {
            return round($plist0Iva * ($muplist2 / 100 + 1), 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function comlista2($plist0Iva, $plist2, $tasiva)
    {
        try {
            return round((($plist2 - $plist0Iva) / ($tasiva / 100 + 1)) * 100 / $plist2, 2);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function destroy(Request $request)
    {
        $this->productRepository->update($request->id, ['active' => 0]);
        return new JsonResponse(['msj' => 'Eliminado ... ', 'type' => 'success']);
    }
}
