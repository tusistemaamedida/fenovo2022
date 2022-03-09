<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockSummary;
use App\Models\Store;
use App\Models\StoreResume;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StockSummaryController extends Controller
{
    public function init(){
        DB::table('stock_summaries')->truncate();
        $stores = Store::where('active',1)->get();
        $products = Product::where('categorie_id',1)->where('active',1)->get();

        foreach ($stores as $store) {
            foreach ($products as $product) {
               $venta_diaria =  $this->getVentaDiaria($product->id,$store->id);
               $stock_actual = $product->stock(null,$store->id);
               $dataStockSummary = [
                    'product_id' => $product->id,
                    'store_id' => $store->id,
                    'daily_sale' => $venta_diaria,
                    'stock_actual' => $stock_actual
               ];

              StockSummary::create($dataStockSummary);
            }

            $total_daily_sale = DB::table('stock_summaries')
                                ->select(DB::raw('SUM(daily_sale) as total_daily_sale'))
                                ->where('store_id', $store->id)
                                ->get()->toArray();
            $total_venta = (is_null($total_daily_sale[0]->total_daily_sale))?0:(float)$total_daily_sale[0]->total_daily_sale;
            $stock_capacity = round($store->stock_capacity - $total_venta,2);
            StoreResume::create([
                'store_id' => $store->id,
                'total_daily_sale' => $total_venta,
                'stock_capacity' => $stock_capacity
            ]);
        }
    }

    //Venta diaria por producto y store
    private function getVentaDiaria($product_id, $store_id) {
        $WEEKS = 4;
        $total = $sem = 0;

        for ($w=0; $w < $WEEKS; $w++) {
          $days_from = $w * 7;
          $days_to = ($w + 1) * 7;
          $date_from = Carbon::now()->subDays($days_from)->format('Y-m-d');
          $date_to =  Carbon::now()->subDays($days_to)->format('Y-m-d');
          $sum = $this->getSumaSalidas($product_id, $store_id, $date_from, $date_to);

          if ($sum && $sum > 0) {
            $total += $sum;
            $sem++;
          }
        }
       $daily_sale = $total > 0 ? $total / (7 * $sem) : 0;
       return round($daily_sale,2);
    }

    // Obtiene el total de ventas semanal del producto y de la store
    private function getSumaSalidas($product_id, $store_id, $date_from, $date_to) {
        $suma = DB::table('movement_products')
                    ->select(DB::raw('SUM(egress) as total_on_week'))
                    ->where('product_id', $product_id)
                    ->where('store_id', $store_id)
                    ->whereBetween(DB::raw('DATE(created_at)'), [$date_to, $date_from])
                    ->get()->toArray();
        return (is_null($suma[0]->total_on_week))?0:(float)$suma[0]->total_on_week;
      }
}
