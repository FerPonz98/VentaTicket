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
        'precio_encomienda',
        'precio_carga',
        'paradas',
    ];

    protected $casts = [
        'hora_salida'             => 'datetime:H:i',
        'paradas'                 => 'array',
        'precio_bus_normal'       => 'decimal:2',
        'recargo_bus_doble_piso'  => 'decimal:2',
        'recargo_bus_1piso_ac'    => 'decimal:2',
        'recargo_semicama'        => 'decimal:2',
        'descuento_3ra_edad'      => 'decimal:2',
        'precio_cortesia'         => 'decimal:2',
        'descuento_discapacidad'   => 'decimal:2',
        'descuento_2'             => 'decimal:2',
        'descuento_3'             => 'decimal:2',
        'precio_encomienda'       => 'decimal:2',
        'precio_carga'            => 'decimal:2',
    ];

    /**
     * Añade una parada nueva con número, precio de pasaje, precio de encomienda, precio de carga y hora de llegada.
     *
     * @param string      $nombre                   Nombre de la parada
     * @param float       $precioPasaje             Precio de pasaje asociado a la parada
     * @param float       $precioEncomiendaParada   Precio de encomienda para esta parada
     * @param float       $precioCargaParada        Precio de carga para esta parada
     * @param string|null $hora                     Hora de llegada en formato H:i (opcional)
     * @return $this
     */
    public function addParada(
        string $nombre,
        float $precioPasaje,
        float $precioEncomiendaParada,
        float $precioCargaParada,
        ?string $hora = null
    ) {
        $paradas = $this->paradas ?? [];
        $numero  = count($paradas) + 1;

        $paradas[] = [
            'numero'                       => $numero,
            'nombre'                       => $nombre,
            'precio_pasaje'                => $precioPasaje,
            'precio_encomienda_parada'     => $precioEncomiendaParada,
            'precio_carga_parada'          => $precioCargaParada,
            'hora'                         => $hora,
        ];

        $this->paradas = $paradas;
        return $this;
    }
    public function viajes()
    {
        return $this->hasMany(\App\Models\Viaje::class);
    }
    public function paradas()
    {
        return $this->hasMany(Parada::class, 'ruta_id');
    }
}
