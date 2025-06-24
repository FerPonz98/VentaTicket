<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'tipo_de_bus',
        'aire_acondicionado',
        'asientos',
        'tv',
        'bano',
        'carga_telefono',
        'placa',
        'marca',
        'modelo',
        'propietario',
        'soat',
        'codigo_soat',
        'soat_vencimiento',
        'rev_tecnica',
        'rev_tecnica_vencimiento',
        'tarjeta_operacion_vencimiento',
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class);
    }

    public function choferes()
    {
        return $this->hasMany(Chofer::class);
    }
}
