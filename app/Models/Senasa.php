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
    ];

    public function movements()
    {
        return $this->belongsToMany(Movement::class);
    }

    public function productos_senasa()
    {
        $arrProducto = [];
        foreach ($this->movements as $movement) {
            foreach ($movement->movement_products as $movi) {
                $producto = Product::find($movi->product_id);
                if ($producto) {
                    $produ             = new stdClass();
                    $produ->cod_fenovo = $producto->cod_fenovo;
                    $produ->name       = $producto->name;
                    $produ->senasa     = $producto->senasa_definition->product_name;
                    array_push($arrProducto, $produ);
                }
            }
        }
        return $arrProducto;
    }
}
