<?php

namespace App\Providers;

use App\Models\Pedido;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $nroPedidos = Pedido::whereStatus('PENDING')->count();

        View::share(['nroPedidos' => $nroPedidos]);
    }
}
