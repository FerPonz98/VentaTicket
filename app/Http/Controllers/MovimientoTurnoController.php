<?php

// app/Http/Controllers/MovimientoTurnoController.php

namespace App\Http\Controllers;

use App\Models\MovimientoTurno;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoTurnoController extends Controller
{
    protected $tiposMovimiento = [
      
       'venta_efectivo','venta_qr','pago_destino','cortesia','servicio_interno','descuento_salida','recibo_salida_bus','recibo_fotocopias','aportes_buses','deposito_efectivo','sobrantes_dia_anterior','cobros','multas','cobro_aportes','pago_recibo_qr','recibo_gastos','compra_materiales','pago_pasaje_qr_oficina','pago_pasajes_cortesias','pago_carga','pago_encomienda'
    ];

    public function registrarIngreso(Request $request)
    {
        $data = $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'monto' => 'required|numeric|min:0',
            'tipo_movimiento' => 'required|in:' . implode(',', $this->tiposMovimiento),
            'descripcion' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $movimiento = MovimientoTurno::registrarIngresoPasaje(
            $data['turno_id'],
            $data['monto'],
            $data['tipo_movimiento'],
            $data['descripcion'] ?? 'Venta de pasaje',
            $data['direccion'] ?? 'ingreso'
        );

        MovimientoTurno::actualizarSaldoTurno($data['turno_id']);

        return response()->json([
            'message' => 'Ingreso registrado correctamente.',
            'movimiento' => $movimiento
        ]);
    }

    public function registrarEgreso(Request $request)
    {
        $data = $request->validate([
            'turno_id' => 'required|exists:turnos,id',
            'monto' => 'required|numeric|min:0',
            'tipo_movimiento' => 'required|in:' . implode(',', $this->tiposMovimiento),
            'descripcion' => 'nullable|string|max:255',
            'direccion' => 'nullable|string|max:255',
        ]);

        $movimiento = MovimientoTurno::registrarEgreso(
            $data['turno_id'],
            $data['monto'],
            $data['tipo_movimiento'],
            $data['descripcion'] ?? 'Pago por concepto de egreso',
            'egreso'   
        );

        MovimientoTurno::actualizarSaldoTurno($data['turno_id']);

        return response()->json([
            'message' => 'Egreso registrado correctamente.',
            'movimiento' => $movimiento
        ]);
    }

    public function verMovimientosTurno($turno_id)
    {
        $turno = Turno::with(['movimientos'])->findOrFail($turno_id);

        return response()->json([
            'turno' => $turno
        ]);
    }

  
    public function obtenerTotalIngresosPorTipo($turno_id, $tipo_movimiento)
    {
        $turno = Turno::findOrFail($turno_id);

        $totalIngresos = $turno->movimientos()->where('tipo_movimiento', $tipo_movimiento)->sum('monto');

        return response()->json([
            'total_ingresos' => $totalIngresos
        ]);
    }

  
    public function obtenerTotalEgresosPorTipo($turno_id, $tipo_movimiento)
    {
        $turno = Turno::findOrFail($turno_id);

        $totalEgresos = $turno->movimientos()->where('tipo_movimiento', $tipo_movimiento)->sum('monto');

        return response()->json([
            'total_egresos' => $totalEgresos
        ]);
    }

    public static function actualizarSaldoTurno($turno_id)
    {
        $turno = Turno::findOrFail($turno_id);

        $sucursal = $turno->sucursal_id;

        $totalIngresos = $turno->movimientos()
            ->where('sucursal_origen', $sucursal)
            ->where('monto', '>', 0)
            ->sum('monto');

        $totalEgresos = $turno->movimientos()
            ->where('sucursal_origen', $sucursal)
            ->where('direccion', 'egreso')
            ->sum('monto');

        $turno->update([
            'saldo_final' => $turno->saldo_inicial + $totalIngresos - $totalEgresos,
        ]);
    }
}
