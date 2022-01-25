<?php

namespace App\Http\Controllers\Admin\Movimientos;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Repositories\CustomerRepository;
use App\Repositories\StoreRepository;
use App\Repositories\ProductRepository;

class SalidasController extends Controller
{
    private $customerRepository;
    private $storeRepository;
    private $productRepository;

    public function __construct(
        CustomerRepository $customerRepository,
        StoreRepository $storeRepository,
        ProductRepository $productRepository
    ){
        $this->productRepository = $productRepository;
        $this->customerRepository   = $customerRepository;
        $this->storeRepository = $storeRepository;
    }

    public function add(){
        return view('admin.movimientos.salidas.add');
    }

    public function getClienteSalida(Request $request){
        $term = $request->term ?: '';
        $valid_names = [];

        if( $request->to_type == 'VENTACLIENTE' ){
            $customers =  $this->customerRepository->search($term);
            foreach ($customers as $customer) {
                $valid_names[] = ['id' => $customer->id, 'text' => $customer->displayName()];
            }
        }else{
            $stores =  $this->storeRepository->search($term);
            foreach ($stores as $store) {
                $valid_names[] = ['id' => $store->id, 'text' => $store->displayName()];
            }
        }

        return \Response::json($valid_names);
    }

    public function searchProducts(Request $request){
        $term = $request->term ?: '';
        $valid_names = [];

        $products = $this->productRepository->search($term);

        foreach ($products as $product) {
            $stock = $product->stock();
            if($stock > 0){
                $valid_names[] = ['id' => $product->id, 'text' => $product->name .' ['.$stock.' '. $product->unit_type.']'];
            }
        }

        return \Response::json($valid_names);
    }
}
