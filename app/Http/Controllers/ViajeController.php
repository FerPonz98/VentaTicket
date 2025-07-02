<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Bus;
use App\Models\Ruta;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ViajeController extends Controller
{
    public function index(Request $request)
    {
        $rutas = Ruta::orderBy('destino')->get();

        $query = Viaje::with(['bus', 'ruta']);

        if ($request->filled('ruta_id')) {
            $query->where('ruta_id', $request->ruta_id);
        }

        if ($request->filled('fecha')) {
            $query->whereDate('fecha_salida', $request->fecha);
        }

        $viajes = $query
            ->orderBy('fecha_salida')
            ->paginate(10)
            ->appends($request->only(['ruta_id','fecha']));

        return view('viajes.index', compact('viajes','rutas'));
    }

    public function create()
    {
        $buses = Bus::pluck('codigo', 'id');
        $rutas = Ruta::pluck('destino', 'id')->map(function($destino, $id) {
            $origen = Ruta::find($id)->origen;
            return "{$origen} → {$destino}";
        });
        $precios = Ruta::pluck('precio_bus_normal', 'id');

        return view('viajes.create', compact('buses','rutas','precios'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bus_id'       => 'required|exists:buses,id',
            'ruta_id'      => 'required|exists:rutas,id',
            'fecha_salida' => 'required|date',
            'precio'       => 'required|numeric|min:0',
        ]);

        Viaje::create($data);

        return redirect()->route('viajes.index')->with('success', 'Viaje creado correctamente.');
    }

    public function show(Viaje $viaje)
    {
        $viaje->load(['bus','ruta']);
        return view('viajes.show', compact('viaje'));
    }

    public function edit(Viaje $viaje)
    {
        $buses = Bus::pluck('codigo', 'id');
        $rutas = Ruta::pluck('destino', 'id')->map(function($destino, $id) {
            $origen = Ruta::find($id)->origen;
            return "{$origen} → {$destino}";
        });
        $precios = Ruta::pluck('precio_bus_normal', 'id');

        return view('viajes.edit', compact('viaje', 'buses', 'rutas', 'precios'));
    }

    public function update(Request $request, Viaje $viaje)
    {
        $data = $request->validate([
            'bus_id'       => 'required|exists:buses,id',
            'ruta_id'      => 'required|exists:rutas,id',
            'fecha_salida' => 'required|date',
            'precio'       => 'required|numeric|min:0',
        ]);

        $viaje->update($data);

        return redirect()->route('viajes.index')
                         ->with('success','Viaje actualizado correctamente.');
    }

    public function destroy(Viaje $viaje)
    {
        $viaje->delete();

        return redirect()->route('viajes.index')
                         ->with('success','Viaje eliminado correctamente.');
    }
}
