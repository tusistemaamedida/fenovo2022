<?php

namespace App\Exports;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use stdClass;

class ListaMayoristaFenovo implements FromView
{
    protected $request;

    use Exportable;

    public function view(): View
    {
        $productos    = Product::whereActive(1)->with('product_price')->get();
        return view('exports.listaMayoristaFenovo', compact('productos'));
    }
}
