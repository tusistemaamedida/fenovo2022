<?php

namespace App\Console\Commands;

use App\Http\Controllers\Cron\StockSummaryController;
use Illuminate\Console\Command;

class StockSummaryDaily extends Command
{

    protected $signature = 'stock:daily';
    protected $description = 'Ejecta a diario la suma de venta diarias para calcular la capacidad de la FTK';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $stockSummary = new StockSummaryController();
        $stockSummary->init();
    }
}
