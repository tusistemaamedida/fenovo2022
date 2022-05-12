<?php

namespace App\Exports;

use App\Models\MovementProduct;
use App\Models\Product;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsViewHistorial implements FromView
{
    protected $id;

    use Exportable;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        $producto    = Product::find($this->id);
        $movimientos = MovementProduct::where('product_id', $this->id)
            ->where('entidad_id', \Auth::user()->store_active)
            ->where('entidad_tipo', 'S')
            ->with('movement')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('exports.movimientosHistorial', compact('movimientos', 'producto'));
    }
}
