<?php

namespace App\Console\Commands;

use App\Exports\ProductsViewExport;
use Illuminate\Console\Command;


class ExportacionProductos extends Command
{
    protected $signature = 'export:products';
    protected $description = 'Exporta los productos actualizados';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $exportPrroducts = (new ProductsViewExport)->store('producto.csv');
        $exportPrroducts->init();
    }
}
