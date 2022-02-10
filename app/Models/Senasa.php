<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use stdClass;

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

    public function productos_senasa()
    {
        $arrProducto = [];
        foreach ($this->movements as $movement) {
            foreach ($movement->movement_salida_products as $movi) {
                $producto = Product::find($movi->product_id);
                if ($producto) {
                    $produ             = new stdClass();
                    $produ->bultos     = $movi->bultos;
                    $produ->peso       = $movi->egress;
                    $produ->cod_fenovo = $producto->cod_fenovo;
                    $produ->name       = $producto->name;
                    $produ->senasa     = $producto->senasa_definition->product_name;
                    array_push($arrProducto, $produ);
                }
            }
        }
        return $arrProducto;
    }

    public function total_senasa()
    {
        $total = 0;
        foreach ($this->movements as $movement) {
            foreach ($movement->movement_products as $movi) {
                $total = $total + $movi->egress;
            }
        }
        return $total;
    }
}
