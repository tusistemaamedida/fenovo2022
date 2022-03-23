<?php

namespace App\Exports;

use App\Models\SessionOferta;
use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class OfertaViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $sessionOfertas = SessionOferta::orderBy('fecha_desde', 'asc')->get();

        return view('exports.oferta', compact('sessionOfertas'));
    }
}
