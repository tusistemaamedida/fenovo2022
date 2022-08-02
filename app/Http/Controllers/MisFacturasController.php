<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Movement;
use App\Models\Panamas;

use App\Models\Store;
use App\Traits\OriginDataTrait;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class MisFacturasController extends Controller
{
    use OriginDataTrait;

    public function inicio()
    {
        return view('admin.mis-facturas.inicio');
    }

    public function check(Request $request)
    {
        $cuit  = $request->cuit;
        $store = Store::where('cuit', $cuit)->where('active', 1)->first();

        if (!$store) {
            $request->session()->flash('error-store', 'cuit no registrada ' . $cuit);
            return view('admin.mis-facturas.inicio');
        }

        if (!$store->password) {
            return redirect()->route('mis.facturas.edit.password', compact('store'));
        }

        if ($store->password !== $request->password) {
            $request->session()->flash('error-store', 'su clave no es válida ');
            return view('admin.mis-facturas.inicio');
        }

        session(['cuit' => $cuit]);
        return redirect()->route('mis.facturas.list');
    }

    public function list(Request $request)
    {
        $cuit = session('cuit');

        if ($request->ajax()) {            

            $invoices = DB::table('invoices as t1')->where('t1.client_cuit', $cuit)
                ->join('movements as t2', 't1.movement_id', '=', 't2.id')
                ->leftJoin('panamas as t3', 't2.id', '=', 't3.movement_id')    
                ->leftJoin('stores as t4', 't2.to', '=', 't4.id')    
                ->select('t1.movement_id', 't1.cae', 't1.updated_at', 't1.client_name', 't1.imp_total', 't1.url', 't1.voucher_number', 't1.updated_at', 
                    't3.tipo',
                    't4.description as tienda')            
                ->orderByDesc('t1.id')
                ->get();

            return Datatables::of($invoices)
                ->editColumn('movement_id', function ($invoice) {
                    return str_pad($invoice->movement_id, 6, '0', STR_PAD_LEFT);
                })
                ->addColumn('fecha', function ($invoice) {
                    return \Carbon\Carbon::parse($invoice->updated_at)->format('d/m/Y');
                })
                ->addColumn('tienda', function ($invoice) {                    
                    return $invoice->tienda;
                })
                ->addColumn('cliente', function ($invoice) {
                    return $invoice->client_name;
                })
                ->addColumn('importe', function ($invoice) {
                    return number_format($invoice->imp_total, 2, ',', '.');
                })
                ->addColumn('url', function ($invoice) {
                    return ($invoice->url) 
                        ?'<a class="text-primary" title="Descargar factura" target="_blank" href="'.$invoice->url.'">'.
                            $invoice->voucher_number.'</a>': null;
                })
                ->addColumn('panama', function ($invoice) {
                    $ruta = route('tiendas.print.panama', ['id' => $invoice->movement_id]);
                    return ($invoice->tipo == 'PAN') ? '<a class="text-primary" title="Descargar PAN" target="_blank" href="' . $ruta . '"> <i class="fa fa-download"></i>  </a>' : null;
                })

                ->addColumn('flete', function ($invoice) {
                    $ruta = route('tiendas.print.flete', ['id' => $invoice->movement_id]);
                    return ($invoice->tipo == 'FLE') ? '<a class="text-primary" title="Descargar FLETE"
                    target="_blank" href="' . $ruta . '"> <i class="fa fa-download"></i> </a>' : null;
                })

                ->rawColumns(['movement_id', 'fecha', 'tienda', 'cliente', 'importe', 'url', 'panama', 'flete'])
                ->make(true);
        }

        return view('admin.mis-facturas.list', compact('cuit'));
    }

    public function editPassword(Request $request)
    {
        $store = Store::find($request->store);
        return view('admin.mis-facturas.modificar-password', compact('store'));
    }

    public function updatePassword(Request $request)
    {
        $store = Store::find($request->store_id);
        $store->update(['password' => $request->password]);
        $request->session()->flash('update-store', 'clave actualizada ');
        return view('admin.mis-facturas.inicio');
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
                $objProduct->palet      = $producto->palet;
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
