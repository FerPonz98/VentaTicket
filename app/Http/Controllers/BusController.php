<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::all();
        return view('buses.index', compact('buses'));
    }

    public function create()
    {
        return view('buses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo'    => 'required|unique:buses|max:10',
            'placa'     => 'required|unique:buses|max:10',
            'capacidad' => 'required|integer|min:1',
            'modelo'    => 'nullable|string|max:50',
        ]);

        Bus::create($data);
        return redirect()->route('buses.index')->with('success', 'Bus creado correctamente.');
    }

    public function edit(Bus $bus)
    {
        return view('buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $data = $request->validate([
            'codigo'    => "required|unique:buses,codigo,{$bus->id}|max:10",
            'placa'     => "required|unique:buses,placa,{$bus->id}|max:10",
            'capacidad' => 'required|integer|min:1',
            'modelo'    => 'nullable|string|max:50',
        ]);

        $bus->update($data);
        return redirect()->route('buses.index')->with('success', 'Bus actualizado correctamente.');
    }

    public function destroy(Bus $bus)
    {
        $bus->delete();
        return redirect()->route('buses.index')->with('success', 'Bus eliminado correctamente.');
    }
}
