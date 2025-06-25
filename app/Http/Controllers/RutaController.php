<?php
namespace App\Http\Controllers;

use App\Models\Ruta;
use App\Models\Stop;
use Illuminate\Http\Request;

class RutaController extends Controller
{
    public function index()
    {
        $rutas = Ruta::with('stops')->get();
        return view('rutas.index', compact('rutas'));
    }

    public function create()
    {
        $stops = Stop::pluck('name');
        return view('rutas.create', compact('stops'));
    }

    public function store(Request $request)
    {
        // Validación de datos
        $data = $request->validate([
            'origen'                   => 'required|string|max:50',
            'destino'                  => 'required|string|max:50',
            'hora_salida'              => 'required|date_format:H:i',
            'precio_base'              => 'required|numeric|min:0',
            'precio_bus_doble_semicama'=> 'required|numeric|min:0',
            'precio_bus_un_piso_semicama'=> 'required|numeric|min:0',
            'precio_3ra_edad'          => 'required|numeric|min:0',
            'precio_cortesia'          => 'required|numeric|min:0',
            'precio_discapacidad'      => 'required|numeric|min:0',
            'descuento2'               => 'nullable|numeric|min:0',
            'descuento3'               => 'nullable|numeric|min:0',
            'stops'                    => 'nullable|array',
            'stops.*'                  => 'exists:stops,name',
            'sequence'                 => 'nullable|array',
            'sequence.*'               => 'integer|min:1',
            'departure_time'           => 'nullable|array',
            'departure_time.*'         => 'nullable|date_format:H:i',
            'precio_parada'            => 'nullable|array',
            'precio_parada.*'          => 'numeric|min:0',
        ]);

        // Crear la ruta
        $ruta = Ruta::create([
            'origen'                   => $data['origen'],
            'destino'                  => $data['destino'],
            'hora_salida'              => $data['hora_salida'],
            'precio_base'              => $data['precio_base'],
            'precio_bus_doble_semicama'=> $data['precio_bus_doble_semicama'],
            'precio_bus_un_piso_semicama'=> $data['precio_bus_un_piso_semicama'],
            'precio_3ra_edad'          => $data['precio_3ra_edad'],
            'precio_cortesia'          => $data['precio_cortesia'],
            'precio_discapacidad'      => $data['precio_discapacidad'],
            'descuento2'               => $data['descuento2'] ?? 0,
            'descuento3'               => $data['descuento3'] ?? 0,
        ]);

        // Asociar las paradas (stops)
        $attach = [];
        $stops         = $data['stops'] ?? [];
        $sequences     = $data['sequence'] ?? [];
        $times         = $data['departure_time'] ?? [];
        $pricesPerStop = $data['precio_parada'] ?? [];

        foreach ($stops as $i => $stopName) {
            $stop = Stop::firstOrCreate(['name' => $stopName]);
            $attach[$stop->id] = [
                'sequence'       => $sequences[$i] ?? ($i + 1),
                'departure_time' => $times[$i] ?? null,
                'precio_parada'  => $pricesPerStop[$i] ?? 0,
            ];
        }

        // Guardar las paradas asociadas
        $ruta->stops()->sync($attach);

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('rutas.index')
            ->with('success', 'Ruta creada correctamente.');
    }

    public function show(Ruta $ruta)
    {
        return view('rutas.show', compact('ruta'));
    }

    public function edit(Ruta $ruta)
    {
        $stops   = Stop::pluck('name');
        $current = $ruta->stops->map(function($stop){
            return array_merge(
                $stop->pivot->toArray(),
                ['stop_name' => $stop->name]
            );
        });
        return view('rutas.edit', compact('ruta','stops','current'));
    }

    public function update(Request $request, Ruta $ruta)
    {
        // Validación de datos
        $data = $request->validate([
            'origen'                   => 'required|string|max:50',
            'destino'                  => 'required|string|max:50',
            'hora_salida'              => 'required|date_format:H:i',
            'precio_base'              => 'required|numeric|min:0',
            'precio_bus_doble_semicama'=> 'required|numeric|min:0',
            'precio_bus_un_piso_semicama'=> 'required|numeric|min:0',
            'precio_3ra_edad'          => 'required|numeric|min:0',
            'precio_cortesia'          => 'required|numeric|min:0',
            'precio_discapacidad'      => 'required|numeric|min:0',
            'descuento2'               => 'nullable|numeric|min:0',
            'descuento3'               => 'nullable|numeric|min:0',
            'stops'                    => 'nullable|array',
            'stops.*'                  => 'exists:stops,name',
            'sequence'                 => 'nullable|array',
            'sequence.*'               => 'integer|min:1',
            'departure_time'           => 'nullable|array',
            'departure_time.*'         => 'nullable|date_format:H:i',
            'precio_parada'            => 'nullable|array',
            'precio_parada.*'          => 'numeric|min:0',
        ]);

        // Actualizar la ruta
        $ruta->update([
            'origen'                   => $data['origen'],
            'destino'                  => $data['destino'],
            'hora_salida'              => $data['hora_salida'],
            'precio_base'              => $data['precio_base'],
            'precio_bus_doble_semicama'=> $data['precio_bus_doble_semicama'],
            'precio_bus_un_piso_semicama'=> $data['precio_bus_un_piso_semicama'],
            'precio_3ra_edad'          => $data['precio_3ra_edad'],
            'precio_cortesia'          => $data['precio_cortesia'],
            'precio_discapacidad'      => $data['precio_discapacidad'],
            'descuento2'               => $data['descuento2'] ?? 0,
            'descuento3'               => $data['descuento3'] ?? 0,
        ]);

        // Asociar las paradas (stops)
        $attach = [];
        $stops         = $data['stops'] ?? [];
        $sequences     = $data['sequence'] ?? [];
        $times         = $data['departure_time'] ?? [];
        $pricesPerStop = $data['precio_parada'] ?? [];

        foreach ($stops as $i => $stopName) {
            $stop = Stop::firstOrCreate(['name' => $stopName]);
            $attach[$stop->id] = [
                'sequence'       => $sequences[$i] ?? ($i + 1),
                'departure_time' => $times[$i] ?? null,
                'precio_parada'  => $pricesPerStop[$i] ?? 0,
            ];
        }

        // Guardar las paradas asociadas
        $ruta->stops()->sync($attach);

        // Redirigir con mensaje de éxito
        return redirect()
            ->route('rutas.index')
            ->with('success', 'Ruta actualizada correctamente.');
    }

    public function destroy(Ruta $ruta)
    {
        $ruta->delete();
        return redirect()
            ->route('rutas.index')
            ->with('success', 'Ruta eliminada correctamente.');
    }
}

