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
        $data = $this->validateRuta($request);

        // Extraer paradas y campos extra
        $paradasInput = $data['paradas'] ?? [];
        unset($data['paradas']);

        // Crear ruta con precios de encomienda y carga
        $ruta = Ruta::create($data);

        // Agregar paradas con todos los precios (hora opcional)
        foreach ($paradasInput as $p) {
            $ruta->addParada(
                $p['nombre'],                   // nombre
                (float)$p['precio_pasaje'],     // precio pasaje
                (float)$p['precio_encomienda_parada'], // precio encomienda
                (float)$p['precio_carga_parada'],      // precio carga
                $p['hora'] ?? null              // hora (puede ser null)
            );
        }
        $ruta->save();

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
        return view('rutas.edit', compact('ruta')); 
    }

    public function update(Request $request, Ruta $ruta)
    {
        $data = $this->validateRuta($request);

        $paradasInput = $data['paradas'] ?? [];
        unset($data['paradas']);

        $ruta->update($data);

        // Reemplazar paradas
        $ruta->paradas = [];
        foreach ($paradasInput as $p) {
            $ruta->addParada(
                $p['nombre'],                   // nombre
                (float)$p['precio_pasaje'],     // precio pasaje
                (float)$p['precio_encomienda_parada'], // precio encomienda
                (float)$p['precio_carga_parada'],      // precio carga
                $p['hora'] ?? null              // hora (opcional)
            );
        }
        $ruta->save();

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

    /**
     * Valida los campos de la ruta y las paradas.
     *
     * @param Request $request
     * @return array
     */
    protected function validateRuta(Request $request): array
    {
        return $request->validate([
            'origen'                         => 'required|string|max:50',
            'destino'                        => 'required|string|max:50',
            'hora_salida'                    => 'nullable|date_format:H:i',
            'precio_bus_normal'              => 'required|numeric|min:0',
            'recargo_bus_doble_piso'         => 'required|numeric|min:0',
            'recargo_bus_1piso_ac'           => 'required|numeric|min:0',
            'recargo_semicama'               => 'nullable|numeric|min:0',
            'descuento_3ra_edad'             => 'required|numeric|min:0',
            'precio_cortesia'                => 'required|numeric|min:0',
            'descuento_discapacidad'         => 'required|numeric|min:0',
            'descuento_2'                    => 'nullable|numeric|min:0',
            'descuento_3'                    => 'nullable|numeric|min:0',
            'precio_encomienda'              => 'required|numeric|min:0',
            'precio_carga'                   => 'required|numeric|min:0',
            'paradas'                        => 'nullable|array',
            'paradas.*.nombre'               => 'required_with:paradas|string|max:100',
            'paradas.*.precio_pasaje'        => 'required_with:paradas|numeric|min:0',
            'paradas.*.precio_encomienda_parada' => 'required_with:paradas|numeric|min:0',
            'paradas.*.precio_carga_parada'  => 'required_with:paradas|numeric|min:0',
            'paradas.*.hora'                 => 'nullable|date_format:H:i',
        ]);
    }
}
