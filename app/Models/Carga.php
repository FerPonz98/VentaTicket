<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Viaje;

class Carga extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cajero_id',
        'nro_guia',
        'estado',
        'origen',
        'destino',
        'remitente_nombre',
        'remitente_ci',
        'remitente_telefono',
    ];

    public function cajero()
    {
        return $this->belongsTo(User::class, 'cajero_id', 'ci_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(DetalleCarga::class);
    }

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }
}


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCarga extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'detalle_cargas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'carga_id',
        'cantidad',
        'descripcion',
        'peso',
    ];
    public function viaje()
    {
        return $this->belongsTo(Viaje::class);
    }
    public function carga()
    {
        return $this->belongsTo(Carga::class);
    }
    public function turno()
{
    return $this->belongsTo(Turno::class);
}

}
