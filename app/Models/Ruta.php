<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $table = 'rutas';

    // Añade aquí todos los campos que tengas en tu tabla rutas
    protected $fillable = [
        'origen',
        'destino',
        'hora_salida',
        'precio_base',
        'recargo_doble_semicama',
        'recargo_un_piso_semicama',
        'descuento_3ra_edad',
        'precio_cortesia',
        'precio_discapacidad',
        'descuento2',
        'descuento3',
    ];

    protected $casts = [
        'hora_salida' => 'datetime:H:i',
    ];

    public function stops()
    {
        return $this->belongsToMany(Stop::class, 'route_stop')
            // sólo estos tres campos del pivot
            ->withPivot(['sequence','departure_time','precio_parada'])
            ->orderBy('pivot_sequence')
            ->withTimestamps();
    }
}
