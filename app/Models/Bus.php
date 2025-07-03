<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $table = 'buses';

    protected $attributes = [
        'asientos_piso1' => 0,
        'asientos_piso2' => 0,
    ];

    protected $fillable = [
        'codigo',
        'placa',
        'tipo_de_bus',
        'asientos_piso1',
        'asientos_piso2',
        'tipo_asiento',
        'aire_acondicionado',
        'tv',
        'bano',
        'carga_telefono',
        'soat',
        'codigo_soat',
        'soat_vencimiento',
        'rev_tecnica',
        'rev_tecnica_vencimiento',
        'tarjeta_operacion_vencimiento',
        'marca',
        'modelo',
        'propietario',
        'chofer_id',
        'layout_piso1',
        'layout_piso2',
    ];

    protected $casts = [
        'asientos_piso1' => 'integer',
        'asientos_piso2' => 'integer',
        'aire_acondicionado' => 'boolean',
        'tv'                => 'boolean',
        'bano'              => 'boolean',
        'carga_telefono'    => 'boolean',
        'soat'              => 'boolean',
        'rev_tecnica'       => 'boolean',
        'soat_vencimiento'  => 'date',
        'rev_tecnica_vencimiento' => 'date',
        'tarjeta_operacion_vencimiento' => 'date',
        'layout_piso1' => 'array',
        'layout_piso2' => 'array',
    ];

    public function viajes()
    {
        return $this->hasMany(Viaje::class);
    }


    public function chofer()
    {
        return $this->belongsTo(\App\Models\Chofer::class, 'chofer_id', 'CI');
    }
}
