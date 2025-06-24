<?php

namespace App\Http\Controllers;

use App\Models\Ruta;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        $rutas = Ruta::all();
        return view('rutas.index', compact('rutas'));
    }

    public function create()
    {
        return view('rutas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'origen'                 => 'required|string|max:100',
            'destino'                => 'required|string|max:100',
            'hora_salida'            => 'required|date_format:H:i',
            'precio_bus_normal'      => 'required|numeric',
            'recargo_bus_doble_piso' => 'required|numeric',
            'recargo_bus_1piso_ac'   => 'required|numeric',
            'recargo_semicama'       => 'required|numeric',
            'descuento_3ra_edad'     => 'required|numeric',
            'precio_cortesia'        => 'required|numeric',
            'descuento_discapacidad' => 'required|numeric',
            'descuento_2'            => 'nullable|numeric',
            'descuento_3'            => 'nullable|numeric',
        ]);

        Ruta::create($data);

        return redirect()->route('rutas.index')
                         ->with('success', 'Ruta creada correctamente.');
    }

    public function show(Ruta $ruta)
    {
        return view('rutas.show', compact('ruta'));
    }

    public function edit(Ruta $ruta)
    {
        return view('rutas.edit', compact('ruta'));
    }

    public function update(Request $request, Ruta $ruta)
    {
        $data = $request->validate([
            'origen'                 => 'required|string|max:100',
            'destino'                => 'required|string|max:100',
            'hora_salida'            => 'required|date_format:H:i',
            'precio_bus_normal'      => 'required|numeric',
            'recargo_bus_doble_piso' => 'required|numeric',
            'recargo_bus_1piso_ac'   => 'required|numeric',
            'recargo_semicama'       => 'required|numeric',
            'descuento_3ra_edad'     => 'required|numeric',
            'precio_cortesia'        => 'required|numeric',
            'descuento_discapacidad' => 'required|numeric',
            'descuento_2'            => 'nullable|numeric',
            'descuento_3'            => 'nullable|numeric',
        ]);

        $ruta->update($data);

        return redirect()->route('rutas.index')
                         ->with('success', 'Ruta actualizada correctamente.');
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();

        return redirect()->route('rutas.index')
                         ->with('success', 'Ruta eliminada correctamente.');
    }
}
