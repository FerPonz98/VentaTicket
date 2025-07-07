<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Turno extends Model
{
    protected $table = 'turnos';
    protected $primaryKey = 'id';

    protected $fillable = [
        'ci_usuario',
        'sucursal_id',
        'tipo',
        'fecha_inicio',
        'fecha_fin',
        'saldo_inicial',
        'saldo_final',
        'abierto',
    ];

    protected $casts = [
        'fecha_inicio'  => 'datetime',
        'fecha_fin'     => 'datetime',
        'saldo_inicial' => 'decimal:2',
        'saldo_final'   => 'decimal:2',
        'abierto'       => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'ci_usuario', 'ci_usuario');
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class, 'sucursal_id', 'id');
    }

    public function movimientos()
    {
        return $this->hasMany(MovimientoTurno::class, 'turno_id', 'id');
    }

    public function scopeAbierto(Builder $q)
    {
        return $q->where('abierto', true);
    }

    public function scopeDe(Builder $q, $ci_usuario, $sucursal_id, $tipo)
    {
        return $q->where('ci_usuario', $ci_usuario)
                 ->where('sucursal_id', $sucursal_id)
                 ->where('tipo', $tipo);
    }

    public function getTotalIngresosAttribute()
    {
        return $this->movimientos()
                    ->where('monto', '>', 0)
                    ->sum('monto');
    }

    public function getTotalEgresosAttribute()
    {
        return $this->movimientos()
                    ->where('monto', '<', 0)
                    ->sum('monto');
    }

    public function getSaldoActualAttribute()
    {
        return $this->saldo_inicial
             + $this->total_ingresos
             + $this->total_egresos;
    }
    protected static function booted()
    {
        
        if (Auth::check() && Auth::user()->rol !== 'admin') {
            static::addGlobalScope('sucursal', function(Builder $builder) {
                $builder->where('sucursal_id', Auth::user()->sucursal);
            });
        }
    }
  
    public static function crearPara($ci_usuario, $sucursal_id, $rol)
    {
        // Buscar el último turno cerrado de la misma sucursal
        $ultimoTurno = self::where('sucursal_id', $sucursal_id)
            ->whereNotNull('fecha_fin')
            ->orderByDesc('fecha_fin')
            ->first();

        $saldoInicial = $ultimoTurno ? $ultimoTurno->saldo_final : 0;

        return self::create([
            'ci_usuario'    => $ci_usuario,
            'sucursal_id'   => $sucursal_id,
            'tipo'          => $rol,
            'fecha_inicio'  => now(),
            'saldo_inicial' => $saldoInicial,
            'abierto'       => true,
        ]);
    }
}
