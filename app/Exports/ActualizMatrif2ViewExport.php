<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ActualizMatrif2ViewExport implements FromView
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $sessionPrices = SessionPrices::orderBy('fecha_actualizacion', 'asc')->get();

        $anio      = date('Y', time());
        $mes       = date('m', time());
        $dia       = date('d', time());
        $hora      = date('H', time());
        $min       = date('i', time());
        $registros = str_pad(count($sessionPrices), 4, '0', STR_PAD_LEFT);

        $data      = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.actualizacionM2', compact('sessionPrices', 'data'));
    }
}
