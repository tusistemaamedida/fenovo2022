<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Cron\ActualizacionPrecios as CronActualizacionPrecios;

class ActualizacionPrecios extends Command
{
    protected $signature = 'update:prices';
    protected $description = 'Ejecuta las actualizaciones de precios programadas';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $updatePrices = new CronActualizacionPrecios();
        $updatePrices->init();
    }
}
