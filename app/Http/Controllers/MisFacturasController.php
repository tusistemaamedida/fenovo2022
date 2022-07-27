<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Movement;
use App\Models\Panamas;

use App\Models\Store;
use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use stdClass;

class MisFacturasController extends Controller
{
    use OriginDataTrait;

    public function inicio()
    {
        return view('admin.mis-facturas.inicio');
    }

    public function getMisFacturas(Request $request)
    {
        $cuit  = $request->cuit;
        $store = Store::where('cuit', $cuit)->where('active', 1)->first();

        if ($store) {
            if (!$store->password) { 
               return redirect()->route('mis.facturas.edit.password', compact('store'));
            }

            if($store->password == $request->password){

                $invoices = Invoice::with(['panama', 'flete'])->where('client_cuit', $cuit)->whereNotNull('cae')->whereNotNull('url')->orderBy('created_at', 'DESC')->get();
                return view('admin.mis-facturas.inicio', compact('invoices'));

            }else{

                $request->session()->flash('error-store', 'Su clave no es válida ');
                return view('admin.mis-facturas.inicio');
            }            
        }
        $request->session()->flash('error-store', 'No existe tienda asociada al CUIT ' . $cuit);
        return view('admin.mis-facturas.inicio');
    }

    public function editPassword()
    {	
        return view('admin.mis-facturas.modificar-password');
    }


    public function updatePassword(Request $request)
    {	
        return $request->password;
        $request->password_verify;
    }

    public function printPanama(Request $request)
    {
        $panama   = Panamas::where('movement_id', $request->id)->where('tipo', 'PAN')->first();
        $movement = Movement::query()->where('id', $request->id)->with('panamas')->first();
        if (isset($panama)) {
            $orden = $panama->orden;
        } else {
            $orden = $movement->orden;
        }

        $store_from = Store::where('id', $movement->from)->first();
        $cip        = (is_null($store_from->cip)) ? '8889' : $store_from->cip;

        if ($movement) {
            $id_panama       = $cip . '-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
            $destino         = $this->origenData($movement->type, $movement->to, false);
            $fecha           = \Carbon\Carbon::parse($panama->created_at)->format('d/m/Y');
            $neto            = 0;
            $array_productos = [];
            $productos       = $movement->group_panamas;
            foreach ($productos as $producto) {
                $subtotal               = $producto->bultos * $producto->unit_price * $producto->unit_package;
                $objProduct             = new stdClass();
                $objProduct->cant       = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->bultos     = $producto->bultos;
                $objProduct->unidad     = $producto->product->unit_type;
                $objProduct->cod_fenovo = $producto->product->cod_fenovo;
                $objProduct->codigo     = $producto->product->cod_fenovo;
                $objProduct->name       = $producto->product->name;
                $objProduct->unit_price = number_format($producto->unit_price, 2, ',', '.');
                $objProduct->subtotal   = number_format($subtotal, 2, ',', '.');
                $objProduct->unity      = '( ' . $producto->unit_package . ' ' . $producto->product->unit_type . ' )';
                $objProduct->total_unit = number_format($producto->bultos * $producto->unit_package, 2, ',', '.');
                $objProduct->class      = '';
                $neto += $subtotal;
                array_push($array_productos, $objProduct);
            }

            $pdf = PDF::loadView('print.panama', compact('destino', 'array_productos', 'neto', 'id_panama', 'fecha'));
            return $pdf->stream($id_panama . '.pdf');
        }
    }

    public function printPanamaFlete(Request $request)
    {
        $panama   = Panamas::where('movement_id', $request->id)->where('tipo', '!=', 'PAN')->first();
        $movement = Movement::query()->where('id', $request->id)->where('flete_invoice', false)->first();

        if (isset($panama)) {
            $orden = $panama->orden;
        } else {
            $orden = $movement->orden;
        }

        $store_from = Store::where('id', $movement->from)->first();
        $cip        = (is_null($store_from->cip)) ? '8889' : $store_from->cip;

        if ($movement) {
            $id_flete               = $cip . '-' . str_pad($orden, 8, '0', STR_PAD_LEFT);
            $destino                = $this->origenData($movement->type, $movement->to, true);
            $fecha                  = \Carbon\Carbon::parse($panama->created_at)->format('d/m/Y');
            $neto                   = 0;
            $array_productos        = [];
            $objProduct             = new stdClass();
            $objProduct->cant       = 1;
            $objProduct->name       = 'FLETE';
            $objProduct->unit_price = number_format($movement->flete, 2, ',', '.');
            $objProduct->subtotal   = $neto   = number_format($movement->flete, 2, ',', '.');
            $objProduct->class      = '';
            array_push($array_productos, $objProduct);
            $pdf = PDF::loadView('print.panamaFelete', compact('destino', 'array_productos', 'neto', 'id_flete', 'fecha'));
            return $pdf->stream($id_flete . '.pdf');
        }
    }
}
