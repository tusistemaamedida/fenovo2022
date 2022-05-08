<?php

namespace App\Exports;

use App\Models\SessionPrices;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class ActualizViewExport implements FromView
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

        return view('exports.actualizacion', compact('sessionPrices'));
    }
}
