<?php

namespace App\Console\Commands;

use App\Exports\CabeEleExport;
use App\Exports\CabeExport;
use App\Exports\DescuentosViewExport;
use App\Exports\ExcepViewExport;
use App\Exports\MovementsViewExport;
use App\Exports\PresentacionesViewExport;
use App\Exports\ProductsViewExport;
use Illuminate\Console\Command;

class SincronizaDiaria extends Command
{
    protected $signature   = 'sincroniza:diariamente';
    protected $description = 'Sincroniza los archivos para Fenovo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Exportar Productos
        (new ProductsViewExport())->store('producto.csv');
        // Exportar Presentaciones
        (new PresentacionesViewExport())->store('bultos.csv');
        // Exportar Descuentos
        (new DescuentosViewExport())->store('des.csv');
        // Exportar Excepciones
        (new ExcepViewExport())->store('excepc.csv');
        // Exportar movimientos
        (new MovementsViewExport() )->store('movi.csv');
        // Exportar FACTURACION ELECTONICA
        (new CabeEleExport())->store('cabe_ele.csv');
        // Exportar PANAMAS Y FLETES
        (new CabeExport())->store('cabe_ped.csv');
    }
}
