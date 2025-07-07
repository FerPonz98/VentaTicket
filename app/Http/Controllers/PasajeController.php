<?php

namespace App\Http\Controllers;

use App\Models\Pasaje;
use App\Models\Viaje;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use App\Models\MovimientoTurno;


class PasajeController extends Controller
{
    public function index(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());
        $user = Auth::user();

        $viajesHoy = Viaje::with(['bus','ruta','pasajes'])
            ->when($user->rol !== 'admin', function ($query) use ($user) {
                $query->where('sucursal_id', $user->sucursal_id);
            })
            ->whereDate('fecha_salida', $fecha)
            ->orderBy('fecha_salida')
            ->get();

        $pasajesRecientes = Pasaje::with(['viaje.bus', 'viaje.ruta'])
            ->when($user->rol !== 'admin', function ($query) use ($user) {
                $query->whereHas('viaje', function($q) use ($user) {
                    $q->where('sucursal_id', $user->sucursal_id);
                });
            })
            ->latest()
            ->take(10)
            ->get();

        return view('pasajes.index', compact('fecha','viajesHoy','pasajesRecientes'));
    }

    public function disponibilidad(Viaje $viaje)
    {
        $viaje->load('bus','ruta','pasajes');
        $capacidad = $viaje->bus->asientos_piso1 + $viaje->bus->asientos_piso2;
        $vendidos  = $viaje->pasajes->count();
        $restantes = max(0, $capacidad - $vendidos);

        return view('pasajes.disponibilidad', compact('viaje','capacidad','vendidos','restantes'));
    }
    public function cerrar(Request $request)
    {
        $data = $request->validate([
            'viaje_id' => 'required|exists:viajes,id',
        ]);
    
        $viaje = Viaje::with([
            'bus.chofer',       
            'chofer',       
            'ruta','pasajes','cargas','encomiendas'
        ])->findOrFail($data['viaje_id']);
    
        $totalPasajes       = $viaje->pasajes->sum('precio');
        $totalCargasPagadas = $viaje->cargas->where('estado_pago','pagado')->sum('monto_total');
        $totalCargasXpagar  = $viaje->cargas->where('estado_pago','por_pagar')->sum('monto_total');
        $totalEncomPagadas  = $viaje->encomiendas->where('estado_pago','pagado')->sum('total');
        $totalEncomXpagar   = $viaje->encomiendas->where('estado_pago','por_pagar')->sum('total');
        $subtotal           = $totalPasajes + $totalCargasPagadas + $totalCargasXpagar 
                            + $totalEncomPagadas + $totalEncomXpagar;
        $retenido           = $subtotal > 500 ? 200 : 0;
        $totalFinal         = $subtotal - $retenido;
    
        $conductorName    = $viaje->chofer?->nombre 
                          ?? $viaje->bus->chofer?->nombre 
                          ?? '–';
        $conductorLicense = $viaje->chofer?->licencia 
                          ?? $viaje->bus->chofer?->licencia 
                          ?? '–';
    
        $pdf = PDF::loadView('pasajes.plantilla_pdf', compact(
            'viaje',
            'totalPasajes','totalCargasPagadas','totalCargasXpagar',
            'totalEncomPagadas','totalEncomXpagar',
            'subtotal','retenido','totalFinal',
            'conductorName','conductorLicense'
        ));
        $pdf->setPaper('legal', 'portrait');
    
        return $pdf->stream("planilla_viaje_{$viaje->id}.pdf");
    }
    
    
 
  
   
    public function create(Request $request)
    {
        $user = Auth::user();

        $sucursalId = \App\Models\Sucursal::where('nombre', $user->sucursal)->value('id');

        $viajes = Viaje::with(['bus', 'ruta'])
            ->when($user->rol !== 'admin', function ($query) use ($sucursalId) {
                $query->where('sucursal_id', $sucursalId);
            })
            ->whereDate('fecha_salida', '>=', now()->toDateString())
            ->orderBy('fecha_salida')
            ->get();

        $tipos = [
            'adulto'       => 'Adulto',
            'tercera_edad' => '3ra Edad',
            'menor'        => 'Menor de Edad',
            'cortesia'     => 'Cortesía',
            'desc'         => 'Descuento',
        ];
        $formasPago = [
            'venta_efectivo'     => 'Efectivo',
            'venta_qr'           => 'QR',
            'pago_destino'       => 'Pago en Destino',
        ];

        $viajeSeleccionado = $request->query('viaje_id');
        $ocupados = [];
        if ($viajeSeleccionado) {
            $ocupados = Pasaje::where('viaje_id', $viajeSeleccionado)
                              ->pluck('asiento')
                              ->map(fn($a) => (int)$a)
                              ->toArray();
        }

        return view('pasajes.create', compact(
            'viajes','tipos','formasPago','viajeSeleccionado','ocupados'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id'        => 'required|exists:viajes,id',
            'origen'          => 'required|string',
            'destino'         => 'required|string',
            'asiento'         => 'required|integer|min:1',
            'nombre_completo' => 'required|string|max:255',
            'ci_usuario'      => 'required|string|max:20',        
            'edad'            => 'required|integer|min:0|max:150',
            'tipo_pasajero'   => 'required|in:adulto,tercera_edad,menor,cortesia,desc',
            'fecha'           => 'required|date',
            'forma_pago'      => 'required|in:venta_efectivo,venta_qr,pago_destino',
            'tipo_descuento'  => 'nullable|in:desc2,desc3',
        ]);
    
        $userRole = Auth::user()->rol; 
        
        if (!in_array($userRole, ['admin', 'supervisor_general', 'supervisor_sucursal'])) {
         
            $turnoAbierto = Turno::de(Auth::user()->ci_usuario, Auth::user()->sucursal, Auth::user()->rol)
                                 ->abierto()
                                 ->first();
    
            if (!$turnoAbierto) {
               
                return back()->withInput()->withErrors(['turno' => 'Debe iniciar un turno antes de poder registrar el pasaje.']);
            }
        }
    
        if ($data['tipo_pasajero'] === 'menor' && $data['edad'] >= 18) {
            return back()->withInput()->withErrors(['edad' => 'No puede seleccionar "Menor de Edad" para mayores de 17 años.']);
        }
    
        if ($data['tipo_pasajero'] === 'tercera_edad' && $data['edad'] <= 60) {
            return back()->withInput()->withErrors(['edad' => 'Solo personas mayores de 60 años pueden ser "3ra Edad".']);
        }
    
        $data['menor_edad']   = $data['edad'] < 18 ? 1 : 0;
        $data['tercera_edad'] = $data['edad'] > 60 ? 1 : 0;
        Session::put('venta.datos', $data);
    
        return redirect()->route('pasajes.confirmar');
    }
    


    public function confirmar()
    {
        $datos = Session::get('venta.datos');
        if (! $datos) {
            return redirect()->route('pasajes.create');
        }

        $viaje = Viaje::with('ruta')->findOrFail($datos['viaje_id']);

        $precio = match($datos['tipo_pasajero']) {
            'tercera_edad' => max(0, $viaje->precio - $viaje->ruta->descuento_3ra_edad),
            'menor'        => max(0, $viaje->precio * 0.5),
            'cortesia'     => 0,
            'desc'         => max(0, $viaje->precio - $viaje->ruta->descuento_2),
            default        => $viaje->precio,
        };

        return view('pasajes.confirmar', compact('datos','viaje','precio'));
    }

    public function finalizar()
{
    $data = Session::pull('venta.datos');
    if (! $data) {
        return redirect()->route('pasajes.create');
    }

    $viaje = Viaje::with('ruta')->findOrFail($data['viaje_id']);
    if (\Carbon\Carbon::parse($viaje->fecha_salida)->lt(now()->startOfDay())) {
        return back()->withInput()->withErrors(['viaje_id' => 'No se puede vender pasaje para un viaje en el pasado.']);
    }

    $precioBase = $viaje->precio;

    $paradas = $viaje->ruta->paradas;
    if (!empty($data['destino']) && is_array($paradas)) {
        foreach ($paradas as $parada) {
            if (
                isset($parada['nombre'], $parada['precio_pasaje']) &&
                $parada['nombre'] === $data['destino']
            ) {
                $precioBase = $parada['precio_pasaje'];
                break;
            }
        }
    }

    $data['origen'] = $viaje->ruta->origen;
    $data['precio'] = match($data['tipo_pasajero']) {
        'tercera_edad' => max(0, $precioBase - $viaje->ruta->descuento_3ra_edad),
        'menor'        => max(0, $precioBase * 0.5),
        'cortesia'     => 0,
        'desc'         => max(0, $precioBase - $viaje->ruta->descuento_2),
        default        => $precioBase,
    };
    $data['cajero_id']       = Auth::user()->ci_usuario;
    $data['hora_en_oficina'] = now()->format('H:i');

    $pasaje = Pasaje::create($data);

    $turno = Turno::de(Auth::user()->ci_usuario, Auth::user()->sucursal, Auth::user()->rol)
                  ->abierto()
                  ->first();

    $precioPasaje = $data['precio'] ?? 0;

    if ($turno) {
        MovimientoTurno::registrarIngreso($turno->id, $precioPasaje, $data['forma_pago'], 'Venta de pasaje ');
        MovimientoTurno::actualizarSaldoTurno($turno->id);
    }

    $pdf = PDF::loadView('pasajes.pdf', ['pasaje' => $pasaje]);
    $pdf->setPaper([0, 0, 226.77, 480], 'portrait');
    return $pdf->stream("pasaje_{$pasaje->id}.pdf");
}
    public function show(Pasaje $pasaje)
    {
        $pasaje->load(['viaje.ruta','cajero']);
        return view('pasajes.show', compact('pasaje'));
    }

    public function ticket(Pasaje $pasaje)
    {
        $pasaje->load(['viaje.ruta','cajero']);
        $pdf = PDF::loadView('pasajes.pdf', ['pasaje' => $pasaje]);
        $pdf->setPaper([0, 0, 226.77, 480], 'portrait'); 
        return $pdf->stream("pasaje_{$pasaje->id}.pdf");
    }

    public function edit(Pasaje $pasaje)
    {
        $viajes     = Viaje::with('ruta')->orderBy('fecha_salida')->get();
        $tipos      = [
            'adulto'       => 'Adulto',
            'tercera_edad' => '3ra Edad',
            'menor'        => 'Menor de Edad',
            'cortesia'     => 'Cortesía',
            'desc'         => 'Descuento',
        ];
        $formasPago = [
            'venta_efectivo'     => 'Efectivo',
            'venta_qr'           => 'QR',
            'pago_destino' => 'Pago en Destino',
        ];

        return view('pasajes.edit', compact('pasaje','viajes','tipos','formasPago'));
    }

    public function update(Request $request, Pasaje $pasaje)
    {
        $data = $request->validate([
            'viaje_id'        => 'required|exists:viajes,id',
            'asiento'         => 'required|integer|min:1',
            'nombre_completo' => 'required|string|max:255',
            'tipo_pasajero'   => 'required|in:adulto,tercera_edad,menor,cortesia,desc',
            'fecha'           => 'required|date',
            'forma_pago'      => 'required|in:venta_efectivo,venta_qr,pago_destino',
        ]);

        $viaje = Viaje::with('ruta')->findOrFail($data['viaje_id']);

        $data['origen']  = $viaje->ruta->origen;
        $data['destino'] = $data['destino']; 
        $data['precio']  = match($data['tipo_pasajero']) {
            'tercera_edad' => max(0, $viaje->precio - $viaje->ruta->descuento_3ra_edad),
            'menor'        => max(0, $viaje->precio * 0.5),
            'cortesia'     => 0,
            'desc'         => max(0, $viaje->precio - $viaje->ruta->descuento_2),
            default        => $viaje->precio,
        };

        $pasaje->update($data);

        return redirect()->route('pasajes.show', $pasaje)
                         ->with('success','Pasaje actualizado correctamente.');
    }

    public function destroy(Pasaje $pasaje)
    {
        $pasaje->delete();

        return redirect()->route('pasajes.index')
                         ->with('success','Pasaje eliminado correctamente.');
    }

    public function viajesPorFecha(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());
        $viajes = Viaje::with(['bus','ruta'])
                       ->whereDate('fecha_salida', $fecha)
                       ->orderBy('fecha_salida')
                       ->get();

        return view('pasajes.viajes_por_fecha', compact('viajes','fecha'));
    }

    public function verVendidosPorViaje(Viaje $viaje)
    {
        $viaje->load(['ruta','pasajes']);
        return view('pasajes.vendidos_por_viaje', compact('viaje'));
    }
  
 
}
