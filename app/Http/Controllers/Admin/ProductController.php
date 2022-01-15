<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;

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
}
