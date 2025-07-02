<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
        public function tickets()
    {
        return $this->hasMany(Pasaje::class);
    }
        public function pasajes(): HasMany
    {
        return $this->hasMany(\App\Models\Pasaje::class, 'viaje_id', 'id');
    }
    protected $casts = [
    'fecha_salida' => 'datetime',
    'cerrado'      => 'boolean',
];
}
