<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getActionsButonTable($actions){
        return '<div class="card-toolbar text-right">
            <button class="btn p-0 shadow-none" type="button" id="dropdowneditButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="svg-icon">
                    <svg width="20px" height="20px" viewBox="0 0 16 16" class="bi bi-three-dots text-body" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z"></path>
                    </svg>
                </span>
            </button>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdowneditButton" >'.$actions. '</div></div>';
    }

    public static function getEntidadTipo($tipo){
        switch ($tipo) {
            case 'COMPRA':
                return 'P';
                break;
            case 'TRASLADO':
            case 'DEVOLUCION':
            case 'VENTA':
            case 'DEVOLUCIONCLIENTE':
                return 'S';
                break;
            case 'VENTACLIENTE':
                return 'C';
                break;
            default:
                # code...
                break;
        }
    }
}
