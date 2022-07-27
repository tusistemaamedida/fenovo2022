<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Store;
use Session;

class MisFacturasController extends Controller
{
    public function getMisFacturas(Request $request){
        $cuit = $request->cuit;
        $store = Store::where('cuit',$cuit)->where('active',1)->first();
        if($store){
            $invoices = Invoice::where('client_cuit',$cuit)->whereNotNull('cae')->whereNotNull('url')->orderBy('created_at','DESC')->get();
            return view('mis-facturas',compact('invoices'));
        }
        $request->session()->flash('error-store', 'No existe tienda asociada al cuit '.$cuit);
        return view('mis-facturas');
    }
}
