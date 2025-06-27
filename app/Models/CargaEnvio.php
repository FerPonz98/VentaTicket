<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargaEnvio extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruta_id',
        'origen_id',
        'destino_id',
        'peso',
        'volumen',
        'precio',
        // otros campos que necesites
    ];

    public function ruta()
    {
        return $this->belongsTo(Ruta::class);
    }

    public function origenStop()
    {
        return $this->belongsTo(Stop::class, 'origen_id');
    }

    public function destinoStop()
    {
        return $this->belongsTo(Stop::class, 'destino_id');
    }
}
