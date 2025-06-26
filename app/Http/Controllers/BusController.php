<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Chofer;
use Illuminate\Http\Request;

class BusController extends Controller
{
    /**
     * Mostrar listado de buses.
     */
    public function index()
    {
        $buses = Bus::with('chofer')->get();
        return view('buses.index', compact('buses'));
    }

    /**
     * Mostrar formulario para crear un nuevo bus.
     */
    public function create()
    {
        $choferes = Chofer::all();
        return view('buses.create', compact('choferes'));
    }

    /**
     * Almacenar un bus recién creado.
     */
    public function store(Request $request)
    {
        
        $rules = [
            'codigo'                        => 'required|unique:buses|max:10',
            'placa'                         => 'required|unique:buses|max:10',
            'tipo_de_bus'                   => 'required|in:Un piso,Doble piso',
            'asientos_piso1'                => 'required|integer|min:1',
            'tipo_asiento'                  => 'required|in:Normal,Semicama,Leito/Semicama',
            'chofer_id'                     => 'required|exists:choferes,id',
            'chofer2_id'                    => 'required|exists:choferes,id',
            'aire_acondicionado'            => 'sometimes|boolean',
            'tv'                            => 'sometimes|boolean',
            'bano'                          => 'sometimes|boolean',
            'carga_telefono'                => 'sometimes|boolean',
            'soat'                          => 'sometimes|boolean',
            'codigo_soat'                   => 'nullable|string|max:50',
            'soat_vencimiento'              => 'nullable|date',
            'rev_tecnica'                   => 'sometimes|boolean',
            'rev_tecnica_vencimiento' => 'nullable|date',
            'tarjeta_operacion_vencimiento' => 'nullable|date',
            'marca'                         => 'nullable|string|max:50',
            'modelo'                        => 'nullable|string|max:50',
            'propietario'                   => 'nullable|string|max:100',
        ];

        if ($request->input('tipo_de_bus') === 'Doble piso') {
            $rules['asientos_piso2'] = 'required|integer|min:1';
        } else {
            $rules['asientos_piso2'] = 'nullable|integer|min:0';
        } 

        $data = $request->validate($rules);

        if ($data['tipo_de_bus'] === 'Un piso') {
            $data['asientos_piso2'] = 0;
        }
    
        $data = $request->validate([
    
            'chofer_id'  => 'required|exists:choferes,id',
            'chofer2_id' => 'nullable|exists:choferes,id|different:chofer_id',
        ]);

        Bus::create($data);

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus creado correctamente.');
    }

    public function show(Bus $bus)
    {
        return view('buses.show', compact('bus'));
    }

   
    public function edit(Bus $bus)
    {
        $choferes = Chofer::all();
        return view('buses.edit', compact('bus', 'choferes'));
    }
    public function update(Request $request, Bus $bus)
    {
        
        $rules = [
            'codigo'                        => "required|unique:buses,codigo,{$bus->id}|max:10",
            'placa'                         => "required|unique:buses,placa,{$bus->id}|max:10",
            'tipo_de_bus'                   => 'required|in:Un piso,Doble piso',
            'asientos_piso1'                => 'required|integer|min:1',
            'asientos_piso2'                => $request->input('tipo_de_bus') === 'Doble piso' ? 'required|integer|min:1' : 'nullable|integer|min:0',
            'tipo_asiento'                  => 'required|in:Normal,Semicama,Leito/Semicama',
            'chofer_id'                     => 'required|exists:choferes,id',
            'chofer2_id'                    => 'nullable|exists:choferes,id|different:chofer_id',
            'aire_acondicionado'            => 'sometimes|boolean',
            'tv'                            => 'sometimes|boolean',
            'bano'                          => 'sometimes|boolean',
            'carga_telefono'                => 'sometimes|boolean',
            'soat'                          => 'sometimes|boolean',
            'codigo_soat'                   => 'nullable|string|max:50',
            'soat_vencimiento'              => 'nullable|date',
            'rev_tecnica'                   => 'sometimes|boolean',
            'rev_tecnica_vencimiento'       => 'nullable|date',
            'tarjeta_operacion_vencimiento' => 'nullable|date',
            'marca'                         => 'nullable|string|max:50',
            'modelo'                        => 'nullable|string|max:50',
            'propietario'                   => 'nullable|string|max:100',
        ];

        $data = $request->validate($rules);

        if ($data['tipo_de_bus'] === 'Un piso') {
            $data['asientos_piso2'] = 0;
        }

        $bus->update($data);

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus actualizado correctamente.');
    }

   
    public function destroy(Bus $bus)
    {
        $bus->delete();

        return redirect()
            ->route('buses.index')
            ->with('success', 'Bus eliminado correctamente.');
    }
}
