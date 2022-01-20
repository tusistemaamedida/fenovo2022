<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Http\Requests\Products\CalculatePrices;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function list(){
        $products = $this->productRepository->paginate(20);
        return view('admin.products.list', compact('products'));
    }

    public function add(){
        return view('admin.products.add');
    }

    public function calculateProductPrices(CalculatePrices $request){
        $plistproveedor = ($request->has('plistproveedor'))?$request->input('plistproveedor'):0;
        $descproveedor  = ($request->has('descproveedor'))?$request->input('descproveedor'):0;

        $mupfenovo  = ($request->has('mupfenovo'))?$request->input('mupfenovo'):0;
        $contribution_fund  = ($request->has('contribution_fund'))?$request->input('contribution_fund'):0;

        $costFenovo = $this->costFenovo($plistproveedor,$descproveedor);
        $plist0Neto = $this->plist0Neto($costFenovo,$mupfenovo,$contribution_fund);

        return new JsonResponse([
            'msj'=>'ok',
            'type'=>'success',
            'costFenovo' => $costFenovo,
            'plist0Neto' => $plist0Neto,
        ]);
    }

    private function costFenovo($plistproveedor,$descproveedor){
        return round($plistproveedor - $plistproveedor *($descproveedor/100),2);
    }

    private function plist0Neto($costFenovo,$mupfenovo,$contribution_fund){
        return round($costFenovo * ($mupfenovo / 100 + 1) * ($contribution_fund / 100 + 1),2);
    }
}
