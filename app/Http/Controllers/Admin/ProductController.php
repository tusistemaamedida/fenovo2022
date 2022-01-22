<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\AlicuotaTypeRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ProducTypeRepository;
use App\Repositories\ProveedorRepository;
use App\Repositories\SenasaDefinitionRepository;
use App\Http\Requests\Products\CalculatePrices;

class ProductController extends Controller
{
    private $productRepository;
    private $alicuotaTypeRepository;
    private $productCategoryRepository;
    private $productTypeRepository;
    private $proveedorRepository;
    private $senasaDefinitionRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductCategoryRepository $productCategoryRepository,
        ProducTypeRepository $productTypeRepository,
        ProveedorRepository $proveedorRepository,
        SenasaDefinitionRepository $senasaDefinitionRepository,
        AlicuotaTypeRepository $alicuotaTypeRepository
    ){
        $this->productRepository = $productRepository;
        $this->alicuotaTypeRepository = $alicuotaTypeRepository;
        $this->productCategoryRepository = $productCategoryRepository;
        $this->productTypeRepository = $productTypeRepository;
        $this->proveedorRepository = $proveedorRepository;
        $this->senasaDefinitionRepository = $senasaDefinitionRepository;
    }

    public function list(){
        $products = $this->productRepository->paginate(20);
        return view('admin.products.list', compact('products'));
    }

    public function add(){
        $alicuotas = $this->alicuotaTypeRepository->get('value','DESC');
        $senasaDefinitions = $this->senasaDefinitionRepository->get('product_name','DESC');
        $categories = $this->productCategoryRepository->getActives('name','ASC');
        $types = $this->productTypeRepository->getActives('name','ASC');
        $proveedores = $this->proveedorRepository->getActives('name','ASC');
        return view('admin.products.add',compact('alicuotas','categories','types','proveedores','senasaDefinitions'));
    }

    public function calculateProductPrices(CalculatePrices $request){
        $plistproveedor = ($request->has('plistproveedor'))?$request->input('plistproveedor'):0;
        $descproveedor  = ($request->has('descproveedor'))?$request->input('descproveedor'):0;

        $mupfenovo  = ($request->has('mupfenovo'))?$request->input('mupfenovo'):0;
        $contribution_fund  = ($request->has('contribution_fund'))?$request->input('contribution_fund'):0;

        $tasiva    = ($request->has('tasiva'))?$request->input('tasiva')*100:21;
        $muplist1  = ($request->has('muplist1'))?$request->input('muplist1'):0;
        $muplist2  = ($request->has('muplist2'))?$request->input('muplist2'):0;
        $p1tienda  = ($request->has('p1tienda'))?$request->input('p1tienda'):0;
        $descp1  = ($request->has('descp1'))?$request->input('descp1'):0;
        $p2tienda  = ($request->has('p2tienda'))?$request->input('p2tienda'):0;
        $descp2  = ($request->has('descp2'))?$request->input('descp2'):0;

        $costFenovo = $this->costFenovo($plistproveedor,$descproveedor);
        $plist0Neto = $this->plist0Neto($costFenovo,$mupfenovo,$contribution_fund);
        $plist0Iva  = $this->plist0Iva($plist0Neto,$tasiva);
        $plist1     = $this->plist1($plist0Iva,$muplist1);
        $comlista1  = $this->comlista1($plist0Iva,$plist1,$tasiva);
        $plist2     = $this->plist2($plist0Iva,$muplist2);
        $comlista2  = $this->comlista2($plist0Iva,$plist2,$tasiva);
        $mup1       = $this->mup1($plist0Iva,$p1tienda);
        $p1may      = $this->p1may($p1tienda,$descp1);
        $mupp1may   = $this->mupp1may($p1may,$plist0Iva);
        $mup2       = $this->mup2($plist0Iva,$p2tienda);
        $p2may      = $this->p2may($p2tienda,$descp2);
        $mupp2may   = $this->mupp2may($p2may,$plist0Iva);

        return new JsonResponse([
            'msj'=>'ok',
            'type'=>'success',
            'costFenovo' => $costFenovo,
            'plist0Neto' => $plist0Neto,
            'plist0Iva' => $plist0Iva,
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
        ]);
    }

    private function mupp2may($p2may,$plist0Iva){
        return round(($p2may / $plist0Iva - 1) * 100 ,2);
    }

    private function p2may($p2tienda,$descp2){
        return round($p2tienda - $p2tienda * ($descp2 / 100) ,2);
    }

    private function mup2($plist0Iva,$p2tienda){
        return round(($p2tienda / $plist0Iva - 1) * 100,2);
    }

    private function mupp1may($p1may,$plist0Iva){
        return round(($p1may / $plist0Iva - 1) * 100 ,2);
    }

    private function p1may($p1tienda,$descp1){
        return round($p1tienda - $p1tienda * ($descp1 / 100) ,2);
    }

    private function mup1($plist0Iva,$p1tienda){
        return round(($p1tienda / $plist0Iva - 1) * 100,2);
    }

    private function costFenovo($plistproveedor,$descproveedor){
        return round($plistproveedor - $plistproveedor *($descproveedor/100),2);
    }

    private function plist0Neto($costFenovo,$mupfenovo,$contribution_fund){
        return round($costFenovo * ($mupfenovo / 100 + 1) * ($contribution_fund / 100 + 1),2);
    }

    private function plist0Iva($plist0Neto,$tasiva){
        return round($plist0Neto * ($tasiva / 100 + 1),2);
    }

    private function plist1($plist0Iva,$muplist1){
        return round($plist0Iva * ($muplist1 / 100 + 1),2);
    }

    private function comlista1($plist0Iva,$plist1,$tasiva){
        return round((($plist1 - $plist0Iva ) / ($tasiva / 100 + 1) * 100) / $plist1,2);
    }

    private function plist2($plist0Iva,$muplist2){
        return round($plist0Iva * ($muplist2 / 100 + 1),2);
    }

    private function comlista2($plist0Iva,$plist2,$tasiva){
        return round((($plist2 - $plist0Iva ) / ($tasiva / 100 + 1)) * 100 / $plist2,2);
    }
}
