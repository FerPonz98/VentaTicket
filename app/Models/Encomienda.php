<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\EncomiendaItem;
use App\Models\Viaje;
use App\Models\User;

class Encomienda extends Model
{
    use HasFactory;

    protected $table = 'encomiendas';

    protected $fillable = [
        'guia_numero',
        'estado',
        'viaje_id',
        'horario',
        'fecha',
        'hora_recepcion',
        'remitente_id',
        'remitente_nombre',
        'remitente_telefono',
        'consignatario_nombre',
        'consignatario_ci',
        'consignatario_telefono',
        'cajero_id',
    ];

    protected $casts = [
        'horario'        => 'datetime:H:i',
        'hora_recepcion' => 'datetime:H:i',
        'fecha'          => 'date',
    ];

    public function viaje(): BelongsTo
    {
        return $this->belongsTo(Viaje::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(EncomiendaItem::class);
    }
    public function cajero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cajero_id', 'ci_usuario');
    }
    public function turno()
    {
        return $this->belongsTo(Turno::class);
    }
}
