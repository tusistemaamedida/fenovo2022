<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ActualizMatrif1ViewExport implements FromView
{
    protected $request;

    use Exportable;

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

        $data = $anio . $mes . $dia . $hora . $min . $registros;

        return view('exports.actualizacionM1', compact('sessionPrices', 'data'));
    }
}
