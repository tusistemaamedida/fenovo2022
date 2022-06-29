<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class Movement
 *
 * @property int         $id
 * @property Carbon|null $date
 * @property string      $type
 * @property string|null $from
 * @property string|null $to
 * @property string|null $status
 * @property string|null $voucher_number
 * @property float|null  $flete
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|MovementProduct[] $movement_products
 *
 * @package App\Models
 */
class Movement extends Model
{
    protected $table = 'movements';

    public $timestamps = true;

    protected $dates = [
        'date',
    ];

    protected $fillable = [
        'date',
        'type',
        'subtype',
        'from',
        'to',
        'status',
        'voucher_number',
        'flete',
        'flete_invoice',
        'orden',
        'exported',
        'user_id',
        'observacion',
    ];

    public function movement_products()
    {
        return $this->hasMany(MovementProduct::class);
    }

    public function movement_salida_products()
    {
        return $this->hasMany(MovementProduct::class)->where('egress', '>', 0);
    }

    public function salida_products_no_cyo()
    {
        return $this->hasMany(MovementProduct::class)->where('egress', '>', 0)->where('circuito', '!=', 'CyO');
    }

    public function salida_products_cyo()
    {
        return $this->hasMany(MovementProduct::class)->where('egress', '>', 0)->where('circuito', 'CyO');
    }

    public function movement_ingreso_products()
    {
        return $this->hasMany(MovementProduct::class)->where('entry', '>', 0);
    }

    public function totalKgrs()
    {
        $kgrs = 0;

        $arrIngreso = ['COMPRA', 'DEVOLUCION', 'DEVOLUCIONCLIENTE'];
        $arrEgreso  = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];
        $mp         = (in_array($this->type, $arrIngreso)) ? $this->movement_ingreso_products : $this->movement_salida_products;

        foreach ($mp as $m) {
            $kgrs += $m->product->unit_weight * $m->unit_package * $m->bultos;
        }

        return round($kgrs, 2);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoice_fenovo()
    {
        $pto_vta = env('PTO_VTA_FENOVO');
        return $invoice   = $this->invoice->where('pto_vta', $pto_vta)->first();
    }

    public function panamas()
    {
        return $this->hasMany(MovementProduct::class)->where('egress', '>', 0)->where('invoice', false);
    }

    public function verifSiFactura()
    {
        return MovementProduct::where('movement_id', $this->id)->where('invoice', true)->count();
    }

    public function hasInvoices()
    {
        return  count($this->hasMany(MovementProduct::class)->where('egress', '>', 0)->where('invoice', '1')->get()) > 0
            ? true
            : false;
    }

    public function hasPanama()
    {
        return Panamas::where('movement_id', $this->id)->where('tipo', 'PAN')->exists();
    }

    public function hasFlete()
    {
        return Panamas::where('movement_id', $this->id)->where('tipo', '!=', 'PAN')->exists();
    }

    public function getPanama()
    {
        return Panamas::where('movement_id', $this->id)->where('tipo', 'PAN')->first();
    }

    public function getFlete()
    {
        return Panamas::where('movement_id', $this->id)->where('tipo', '!=', 'PAN')->first();
    }

    public function senasa()
    {
        return $this->belongsToMany(Senasa::class);
    }

    public function From($type, $returnObject = false)
    {
        switch ($type) {
            case 'COMPRA':
                $Proveedor = Proveedor::find($this->from);
                if ($returnObject) {
                    return $Proveedor;
                }
                return $Proveedor->name;
            case 'VENTA':
            case 'TRASLADO':
            case 'AJUSTE':
            case 'DEVOLUCION':
            case 'DEBITO':
            case 'VENTACLIENTE':
                $Store = Store::find($this->from);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'DEVOLUCIONCLIENTE':
                $customer = Customer::find($this->to);
                return $customer->razon_social;
        }
    }

    public function To($type, $returnObject = false)
    {
        switch ($type) {
            case 'COMPRA':
            case 'VENTA':
            case 'TRASLADO':
            case 'AJUSTE':
            case 'DEBITO':
            case 'DEVOLUCION':
                $Store = Store::find($this->to);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'DEVOLUCIONCLIENTE':
                $Store = Store::find($this->from);
                if ($returnObject) {
                    return $Store;
                }
                return $Store->description;
            case 'VENTACLIENTE':
                $Customer = Customer::find($this->to);
                if ($returnObject) {
                    return $Customer;
                }
                return $Customer->razon_social;
        }
    }

    public function origenData($type)
    {
        $typeTo = $this->to;
        if (($type == 'TRASLADO' && Auth::user()->store_active == $typeTo) || $type == 'VENTA' && Auth::user()->store_active == $typeTo) {
            $typeTo = $this->from;
        }

        switch ($type) {
            case 'COMPRA':
                $proveedor = Proveedor::find($this->from);
                return $proveedor->name;
            case 'VENTA':
            case 'TRASLADO':
            case 'DEVOLUCION':
            case 'DEBITO':
                $store = Store::find($typeTo);
                return $store->description;
            case 'VENTACLIENTE':
            case 'DEBITOCLIENTE':
            case 'DEVOLUCIONCLIENTE':
                $customer = Customer::find($typeTo);
                return $customer->razon_social;
        }
    }

    public function cantidad_ingresos()
    {
        return count($this->hasMany(MovementProduct::class)->get()->groupBy('product_id'));
    }

    public function neto()
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $netoInvoice = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package * mp.tasiva) as netoInvoice')])
            ->orderBy('m.date', 'ASC')
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.invoice', '=', 1)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->whereIn('m.type', $arrEgreso)
            ->pluck('netoInvoice')
            ->first();

        return new JsonResponse(['netoInvoice' => number_format($netoInvoice, 2, ',', '')]);
    }

    public function neto21($invoice)
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $neto = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package) as neto21'),
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package * 0.21) as neto_iva21'),
            ])
            ->orderBy('m.date', 'ASC')
            ->where('mp.tasiva', 21)
            ->where('mp.iibb', true)
            ->where('mp.invoice', $invoice)
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->whereIn('m.type', $arrEgreso)->first();

        return $neto;
    }

    public function neto105($invoice)
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $neto = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package) as neto105'),
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package * 0.105) as neto_iva105'),
            ])
            ->orderBy('m.date', 'ASC')
            ->where('mp.tasiva', 10.5)
            ->where('mp.iibb', true)
            ->where('mp.invoice', $invoice)
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->whereIn('m.type', $arrEgreso)->first();

        return $neto;
    }

    public function totalConIva($invoice)
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $neto = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package * (1+(mp.tasiva/100))) as totalConIva'),
            ])
            ->orderBy('m.date', 'ASC')
            ->where('mp.iibb', true)
            ->where('mp.invoice', $invoice)
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->whereIn('m.type', $arrEgreso)->first();

        return $neto;
    }

    public function totalIibb($invoice)
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $neto = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([
                DB::raw('SUM(mp.bultos * mp.unit_price * mp.unit_package) as total_no_gravado'),
            ])
            ->orderBy('m.date', 'ASC')
            ->where('mp.iibb', false)
            ->where('mp.invoice', $invoice)
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->whereIn('m.type', $arrEgreso)->first();

        return $neto;
    }

    public function cosventa($invoice)
    {
        $arrEgreso = ['VENTA', 'VENTACLIENTE', 'TRASLADO'];

        $neto = DB::table('movements as m')
            ->join('movement_products as mp', 'mp.movement_id', '=', 'm.id')
            ->groupBy('mp.movement_id')
            ->select([
                DB::raw('SUM(mp.cost_fenovo) as cost_venta'),
            ])
            ->orderBy('m.date', 'ASC')
            ->where('m.id', $this->id)
            ->where('mp.egress', '>', 0)
            ->where('mp.entidad_id', \Auth::user()->store_active)
            ->where('mp.entidad_tipo', 'S')
            ->where('mp.invoice', $invoice)
            ->whereIn('m.type', $arrEgreso)->first();

        return $neto;
    }
}
