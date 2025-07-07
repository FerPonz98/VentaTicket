<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descuento extends Model
{
    use HasFactory;

    protected $table = 'descuentos';  

    protected $fillable = [
        'viaje_id',
        'valor_descuento',
        'tipo_descuento',
        'codigo_descuento',
    ];

    protected $casts = [
        'valor_descuento' => 'decimal:2',
        'tipo_descuento'  => 'string',
    ];

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }
}
