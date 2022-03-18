<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class DescuentosViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $desde = $this->request->desde;
        $hasta = $this->request->hasta;

        $descuentos = DB::table('product_descuentos')
            ->select('codigo', 'descripcion', 'descuento', 'cantidad')
            ->where('active', 1)
            ->get();

        return view('exports.descuentos', compact('descuentos'));
    }
}
