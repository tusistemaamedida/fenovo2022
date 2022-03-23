<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SessionPrices;
use App\Models\HistorialActualizacion;
use App\Repositories\SessionPricesRepository;
use App\Repositories\ProductPriceRepository;
use App\Repositories\OfertaRepository;
use Carbon\Carbon;

class ActualizacionPrecios extends Controller
{
    private $sessionPricesRepository;
    private $productPriceRepository;
    private $ofertaRepository;

    public function init()
    {
        $this->sessionPricesRepository = new SessionPricesRepository();
        $this->productPriceRepository  = new ProductPriceRepository();
        $this->ofertaRepository        = new OfertaRepository();

        $hoy = Carbon::parse(now())->format('Y-m-d');
        $ayer = Carbon::parse(now())->subDays(1)->format('Y-m-d');
        $session_prices = $this->sessionPricesRepository->getBy('fecha_actualizacion',$hoy);
        foreach ($session_prices as $sp) {
            $prices = $sp->toArray();
            $product_id = $prices['product_id'];
            unset($prices['id'],$prices['product_id'],$prices['fecha_actualizacion'],$prices['updated_at'],$prices['created_at']);
            $product_updated = $this->productPriceRepository->updateWhere('product_id',$product_id,$prices);
            $product_updated['product_id'] = $product_id;
            HistorialActualizacion::create($product_updated);
            $this->sessionPricesRepository->delete($sp->id);
        }
        $this->ofertaRepository->deleteWhere('fecha_hasta',$ayer);
    }
}
