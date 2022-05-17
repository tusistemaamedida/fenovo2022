<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Invoice
 *
 * @property int $id
 * @property int|null $cant_reg
 * @property int|null $movement_id
 * @property string|null $client_name
 * @property string|null $client_address
 * @property string|null $client_cuit
 * @property string|null $client_iva_type
 * @property string|null $voucher_number
 * @property int|null $pto_vta
 * @property int|null $cbte_tipo
 * @property int|null $concepto
 * @property int|null $doc_tipo
 * @property int|null $doc_nro
 * @property int|null $cbte_desde
 * @property int|null $cbte_hasta
 * @property int|null $cbte_fch
 * @property int|null $fch_serv_desde
 * @property int|null $fch_serv_hasta
 * @property int|null $fch_vto_pago
 * @property float|null $imp_total
 * @property float|null $imp_tot_conc
 * @property float|null $imp_neto
 * @property float|null $imp_op_ex
 * @property float|null $imp_iva
 * @property float|null $imp_trib
 * @property float|null $iibb
 * @property string|null $mon_id
 * @property int|null $mon_cotiz
 * @property string|null $ivas
 * @property string|null $cae
 * @property string|null $expiration
 * @property string|null $key
 * @property string|null $error
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Invoice extends Model
{
	protected $table = 'invoices';

	protected $casts = [
		'cant_reg' => 'int',
		'movement_id' => 'int',
		'pto_vta' => 'int',
		'cbte_tipo' => 'int',
		'concepto' => 'int',
		'doc_tipo' => 'int',
		'doc_nro' => 'int',
		'cbte_desde' => 'int',
		'cbte_hasta' => 'int',
		'cbte_fch' => 'int',
		'fch_serv_desde' => 'int',
		'fch_serv_hasta' => 'int',
		'fch_vto_pago' => 'int',
		'imp_total' => 'float',
		'imp_tot_conc' => 'float',
		'imp_neto' => 'float',
		'imp_op_ex' => 'float',
		'imp_iva' => 'float',
		'imp_trib' => 'float',
		'iibb' => 'float',
		'mon_cotiz' => 'int'
	];

	protected $fillable = [
		'cant_reg',
		'movement_id',
		'client_name',
		'client_address',
		'client_cuit',
		'client_iva_type',
		'voucher_number',
		'pto_vta',
		'cbte_tipo',
		'concepto',
		'doc_tipo',
		'doc_nro',
		'cbte_desde',
		'cbte_hasta',
		'cbte_fch',
		'fch_serv_desde',
		'fch_serv_hasta',
		'fch_vto_pago',
		'imp_total',
		'imp_tot_conc',
		'imp_neto',
		'imp_op_ex',
		'imp_iva',
		'imp_trib',
		'iibb',
		'mon_id',
		'mon_cotiz',
		'ivas',
		'cae',
		'expiration',
		'key',
		'error',
        'costo_fenovo_total',
        'orden',
        'tributos'
	];

    public function tipoFactura(){
        return $this->belongsTo(VoucherType::class, 'cbte_tipo', 'id');
    }
}
