<?php
// app/Models/MovimientoTurno.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoTurno extends Model
{
    protected $table = 'movimientos_turno';
    protected $primaryKey = 'id';

    public $timestamps = true; 

    protected $fillable = [
        'turno_id',
        'tipo_movimiento',
        'descripcion',
        'monto',
        'es_pago_pendiente',
        'sucursal_origen',
        'pago_en_destino',
        'sincronizado',
        'direccion'
    ];

    public function turno()
    {
        return $this->belongsTo(Turno::class, 'turno_id', 'id');
    }

    public static function registrarIngreso($turno_id, $monto, $tipo_movimiento, $descripcion)
    {
        return self::create([
            'turno_id' => $turno_id,
            'tipo_movimiento' => $tipo_movimiento,
            'descripcion' => $descripcion,
            'monto' => $monto,
            'es_pago_pendiente' => false,
            'sincronizado' => true, 
            'direccion' => 'ingreso'
        ]);
    }

    public static function registrarEgreso($turno_id, $monto, $tipo_movimiento, $descripcion)
    {
        return self::create([
            'turno_id' => $turno_id,
            'tipo_movimiento' => $tipo_movimiento,
            'descripcion' => $descripcion,
            'monto' => -$monto, 
            'es_pago_pendiente' => false,
            'sincronizado' => true,
            'direccion' => 'egreso'
        ]);
    }

    public static function actualizarSaldoTurno($turno_id)
    {
        $turno = Turno::findOrFail($turno_id);
        
        $totalIngresos = $turno->movimientos()->where('monto', '>', 0)->sum('monto');
        $totalEgresos = $turno->movimientos()->where('monto', '<', 0)->sum('monto');

        $turno->update([
            'saldo_final' => $turno->saldo_inicial + $totalIngresos + $totalEgresos,
        ]);
    }
}
