<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductos(Request $request)
    {
        return Product::name($request->name)->codFenovo($request->codfenovo)->get();
    }
}
