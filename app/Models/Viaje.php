<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chofer;       // <--- importa tu modelo Chofer
use Illuminate\Database\Eloquent\Relations\HasMany;

class Viaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'ruta_id',
        'fecha_salida',
        'precio',
        'cerrado',
        'chofer_id',       
        'sucursal_id',  
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }

    public function pasajes(): HasMany
    {
        return $this->hasMany(\App\Models\Pasaje::class, 'viaje_id', 'id');
    }

    public function cargas()
    {
        return $this->hasMany(Carga::class);
    }

    public function encomiendas()
    {
        return $this->hasMany(Encomienda::class);
    }
    public function chofer()
    {
        return $this->belongsTo(Chofer::class, 'chofer_id', 'CI');
    }
}
