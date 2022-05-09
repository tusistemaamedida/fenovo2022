<?php

namespace App\Console\Commands;

use App\Exports\MovementsViewExport;
use Illuminate\Console\Command;

class SincronizaMovimientos extends Command
{
    protected $signature   = 'sincroniza:movimientos';
    protected $description = 'Sincroniza los movimientos de Fenovo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Exportar Movimientos
        (new MovementsViewExport())->store('movi.csv');
    }
}
