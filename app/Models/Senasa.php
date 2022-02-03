<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
