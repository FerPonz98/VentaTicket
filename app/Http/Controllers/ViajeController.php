<?php

namespace App\Http\Controllers;

use App\Models\Viaje;
use App\Models\Bus;
use App\Models\Ruta;
use Illuminate\Http\Request;

class ViajeController extends Controller
{
    public function index()
    {
        $viajes = Viaje::with(['bus', 'ruta'])->get();
        return view('viajes.index', compact('viajes'));
    }

    public function create()
    {
        $buses  = Bus::pluck('codigo', 'id');
        $rutas  = Ruta::pluck('destino', 'id')->map(function($destino, $id) {
            $origen = Ruta::find($id)->origen;
            return "{$origen} → {$destino}";
        });
        return view('viajes.create', compact('buses', 'rutas'));
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

        return redirect()->route('viajes.index')
                         ->with('success', 'Viaje creado correctamente.');
    }

    public function show(Viaje $viaje)
    {
        $viaje->load(['bus', 'ruta']);
        return view('viajes.show', compact('viaje'));
    }

    public function edit(Viaje $viaje)
    {
        $buses  = Bus::pluck('codigo', 'id');
        $rutas  = Ruta::pluck('destino', 'id')->map(function($destino, $id) {
            $origen = Ruta::find($id)->origen;
            return "{$origen} → {$destino}";
        });
        return view('viajes.edit', compact('viaje', 'buses', 'rutas'));
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
                         ->with('success', 'Viaje actualizado correctamente.');
    }

    public function destroy(Viaje $viaje)
    {
        $viaje->delete();

        return redirect()->route('viajes.index')
                         ->with('success', 'Viaje eliminado correctamente.');
    }
}
