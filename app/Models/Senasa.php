<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class Senasa
 *
 * @property int         $id
 * @property string|null $habilitacion_nro
 * @property string|null $patente_nro
 * @property string|null $precintos
 * @property string|null $destino
 * @property string|null $dias_validez
 * @property string|null $fecha
 * @property string|null $hora
 *
 * @package App\Models
 */
class Senasa extends Model
{
    protected $table = 'senasa';

    public $timestamps = true;

    protected $fillable = [
        'habilitacion_nro',
        'patente_nro',
        'precintos',
        'destino',
        'dias_validez',
        'fecha_salida',
        'hora_salida',
    ];

    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }

    public function productos_senasa($id)
    {
        $productos = DB::table('senasa as t1')
            ->join('movement_senasa as t2', 't1.id', '=', 't2.senasa_id')
            ->join('movements as t3', 't3.id', '=', 't2.movement_id')
            ->join('movement_products as t4', 't4.movement_id', '=', 't3.id')
            ->join('products as t5', 't4.product_id', '=', 't5.id')
            ->join('senasa_definitions as t6', 't5.senasa_id', '=', 't6.id')
            ->select([DB::raw('t6.product_name as name'), DB::raw('SUM(t4.bultos) as bultos'), DB::raw('SUM(t4.egress) as kilos')])
            ->groupBy('t5.senasa_id')
            ->orderBy('t5.name', 'ASC')
            ->where('t4.egress', '>', 0)
            ->where('t1.id', '=', $id)
            ->where('t5.senasa_id', '!=', null)->get();

        return $productos;
    }
}
