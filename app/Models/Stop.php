<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stop extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function rutas()
    {
        return $this->belongsToMany(Ruta::class, 'route_stop')
                    ->withPivot([
                        'sequence',
                        'departure_time',
                        'precio_bus_normal',
                        'precio_bus_doble_semicama',
                        'precio_bus_un_piso_semicama',
                        'precio_3ra_edad',
                        'precio_cortesia',
                        'precio_discapacidad',
                        'descuento2',
                        'descuento3',
                    ])
                    ->withTimestamps();
    }
}
