<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_id',
        'ruta_id',
        'fecha_salida',
        'precio',
    ];

    public function bus()
    {
        return $this->belongsTo(Bus::class);
    }

    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }
}
