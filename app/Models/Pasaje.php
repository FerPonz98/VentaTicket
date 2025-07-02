<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Viaje;
use App\Models\User;

class Pasaje extends Model
{
    use HasFactory;

    protected $table = 'pasajes';

    protected $fillable = [
        'viaje_id',
        'origen',
        'destino',
        'nombre_completo',
        'tipo_pasajero',
        'precio',
        'asiento',
        'tipo_asiento',
        'forma_pago',
        'cajero_id',
        'hora_en_oficina',
        'tercera_edad',
        'menor_edad',
        'fecha',
    ];

    protected $casts = [
        'tercera_edad'    => 'boolean',
        'menor_edad'      => 'boolean',
        'fecha'           => 'date',
        'hora_en_oficina' => 'string',
        'precio'          => 'decimal:2',
    ];

    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }

    public function cajero()
    {
        return $this->belongsTo(User::class, 'cajero_id', 'ci_usuario');
    }
public function usuario()
{
    return $this->belongsTo(User::class, 'usuario_id', 'ci_usuario');
}
}
