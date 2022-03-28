<?php

namespace App\Exports;

use App\Models\SessionOferta;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExcepViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $sessionOfertas = SessionOferta::has('stores')->with('stores')->orderBy('fecha_desde', 'asc')->get();

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($sessionOfertas), 4, '0', STR_PAD_LEFT);

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.excepciones', compact('sessionOfertas', 'data'));
    }
}
