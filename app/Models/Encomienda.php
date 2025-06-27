<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Encomienda extends Model
{
    use HasFactory;

    protected $fillable = [
        'ruta_id',
        'origen_id',
        'destino_id',
        'peso',
        'precio',
        // añade aquí campos extra (volumen, descripción, etc.)
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
