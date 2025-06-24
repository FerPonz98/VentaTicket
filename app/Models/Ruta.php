<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';

    protected $fillable = [
        'origen',
        'destino',
        'hora_salida',
        'precio_bus_normal',
        'recargo_bus_doble_piso',
        'recargo_bus_1piso_ac',
        'recargo_semicama',
        'descuento_3ra_edad',
        'precio_cortesia',
        'descuento_discapacidad',
        'descuento_2',
        'descuento_3',
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class);
    }
}
