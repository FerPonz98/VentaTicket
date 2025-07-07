<?php

namespace App\Http\Controllers;

use App\Models\Turno;
use App\Models\MovimientoTurno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Sucursal;

class TurnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $rol = auth()->user()->rol;
        $query = Turno::query();

        if (in_array($rol, ['admin', 'supervisor gral']) && $request->filled('sucursal_id')) {
            $query->where('sucursal_id', $request->sucursal_id);
        }

        if ($rol === 'Supervisor SUC') {
            $query->where('sucursal_id', auth()->user()->sucursal);
        }

        $turnosCerrados = $query->whereNotNull('fecha_fin')->orderByDesc('fecha_fin')->get();
        $sucursales = Sucursal::all();

        $turnoAbierto = Turno::where('ci_usuario', auth()->user()->ci_usuario)
            ->whereNull('fecha_fin')
            ->first();

        return view('turnos.index', compact('turnosCerrados', 'sucursales', 'turnoAbierto'));
    }

    public function open(Request $request)
    {
        $user = Auth::user();

        $existe = $user->rol === 'admin'
            ? Turno::abierto()->exists()
            : Turno::de($user->ci_usuario, $user->sucursal, $user->rol)
                  ->abierto()
                  ->exists();

        if ($existe) {
            return back()->withErrors('Ya tienes un turno abierto.');
        }

        $turno = Turno::crearPara(
            $user->ci_usuario,
            $user->sucursal,
            $user->rol
        );

        return redirect()
            ->route('turnos.index')
            ->with('success', "Turno #{$turno->id} abierto. Saldo inicial: {$turno->saldo_inicial}");
    }

    public function close(Request $request, Turno $turno)
    {
        $this->authorize('update', $turno);

        $user = Auth::user();
        if ($user->rol !== 'admin' && $turno->sucursal_id !== $user->sucursal) {
            abort(403);
        }

        if (! $turno->abierto) {
            return back()->withErrors('Este turno ya está cerrado.');
        }

        $request->validate([
            'saldo_final' => 'required|numeric|min:0',
        ]);

        $turno->update([
            'saldo_final' => $request->input('saldo_final'),
            'fecha_fin'   => now(),
            'abierto'     => false,
        ]);

        return redirect()
            ->route('turnos.index')
            ->with('success', "Turno #{$turno->id} cerrado. Saldo final: {$turno->saldo_final}");
    }

    public function show(Turno $turno)
    {
        $this->authorize('view', $turno);

        $user = Auth::user();
        if ($user->rol !== 'admin' && $turno->sucursal_id !== $user->sucursal) {
            abort(403);
        }

        $turno->load('movimientos');

        $totales = [
            'ingresos' => $turno->movimientos()->where('monto', '>', 0)->sum('monto'),
            'egresos'  => $turno->movimientos()->where('monto', '<', 0)->sum('monto'),
            'neto'     => $turno->movimientos()->sum('monto'),
        ];

        return view('turnos.show', compact('turno', 'totales'));
    }

    public function ingresos(Turno $turno)
    {
        return view('turnos.ingresos', compact('turno'));
    }

    public function registrarIngreso(Request $request, Turno $turno)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'tipo_movimiento' => 'required|in:venta_efectivo,venta_qr,pago_destino,cortesia,servicio_interno,descuento_salida,recibo_salida_bus,recibo_fotocopias,aportes_buses,deposito_efectivo,sobrantes_dia_anterior,cobros,multas,cobro_aportes',
        ]);
    
        $movimiento = MovimientoTurno::registrarIngreso(
            $turno->id,                   
            $data['monto'],                 
            $data['tipo_movimiento'],      
            $data['descripcion'] ?? 'Venta de pasaje' 
        );
    
        MovimientoTurno::actualizarSaldoTurno($turno->id);
    
        return redirect()->route('turnos.show', $turno->id)
                         ->with('success', 'Ingreso registrado correctamente.');
    }

    public function egresos(Turno $turno)
    {
        return view('turnos.egresos', compact('turno'));
    }


public function registrarEgreso(Request $request, Turno $turno)
{
    $data = $request->validate([
        'descripcion' => 'required|string|max:255',
        'monto'       => 'required|numeric|min:0',
        'tipo_movimiento' => 'required|in:pago_recibo_qr,recibo_gastos,compra_materiales,pago_pasaje_qr_oficina,pago_pasajes_cortesias',
    ]);

    \App\Models\MovimientoTurno::create([
        'turno_id' => $turno->id,
        'tipo_movimiento' => $data['tipo_movimiento'],
        'descripcion' => $data['descripcion'],
        'monto' => abs($data['monto']), 
        'es_pago_pendiente' => false,
        'sucursal_origen' => $turno->sucursal_id,
        'pago_en_destino' => null,
        'sincronizado' => false,
        'direccion' => 'egreso',
    ]);

    \App\Models\MovimientoTurno::actualizarSaldoTurno($turno->id);

    return redirect()->route('turnos.show', $turno->id)
        ->with('success', 'Egreso registrado correctamente.');
}
    public function egresosStore(Request $request, Turno $turno)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto'       => 'required|numeric|min:0',
            'tipo_movimiento' => 'required|in:pago_recibo_qr,recibo_gastos,compra_materiales,pago_pasaje_qr_oficina,pago_pasajes_cortesias',
        ]);
        \App\Models\MovimientoTurno::create([
            'turno_id' => $turno->id,
            'tipo_movimiento' => $data['tipo_movimiento'],
            'descripcion' => $data['descripcion'],
            'monto' => $data['monto'],
            'es_pago_pendiente' => false,
            'sucursal_origen' => $turno->sucursal_id,
            'pago_en_destino' => null,
            'sincronizado' => false,
            'direccion' => 'egreso',
        ]);

        MovimientoTurno::actualizarSaldoTurno($turno->id);

        return redirect()->route('turnos.show', $turno->id)
                         ->with('success', 'Egreso registrado correctamente.');
    }

    public function ingresosStore(Request $request, Turno $turno)
    {
        $data = $request->validate([
            'descripcion' => 'required|string|max:255',
            'monto' => 'required|numeric|min:0',
            'tipo_movimiento' => 'required|in:venta_efectivo,venta_qr,pago_destino,cortesia,servicio_interno,descuento_salida,recibo_salida_bus,recibo_fotocopias,aportes_buses,deposito_efectivo,sobrantes_dia_anterior,cobros,multas,cobro_aportes',
        ]);

        \App\Models\MovimientoTurno::create([
            'turno_id' => $turno->id,
            'tipo_movimiento' => $data['tipo_movimiento'],
            'descripcion' => $data['descripcion'],
            'monto' => $data['monto'],
            'es_pago_pendiente' => false,
            'sucursal_origen' => $turno->sucursal_id,
            'pago_en_destino' => null,
            'sincronizado' => false,
            'direccion' => 'ingreso',
        ]);

        \App\Models\MovimientoTurno::actualizarSaldoTurno($turno->id);

        return redirect()->route('turnos.index', $turno->id)
            ->with('success', 'Ingreso registrado correctamente.');
    }
}
