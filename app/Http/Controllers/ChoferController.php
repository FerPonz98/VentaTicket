<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use Illuminate\Http\Request;

class ChoferController extends Controller
{
    public function index()
    {
        $choferes = Chofer::all();
        return view('choferes.index', compact('choferes'));
    }

    public function create()
    {
        return view('choferes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'numero'               => 'required|integer',
            'bus_codigo'           => 'required|string|max:10',
            'nombre_chofer'        => 'required|string|max:255',
            'licencia'             => 'required|string|max:50',
            'vencimiento_licencia' => 'required|date',
        ]);
    
        Chofer::create($data);

        return redirect()
            ->route('choferes.index')
            ->with('success', 'Chofer creado correctamente.');
    }

    public function show(Chofer $chofer)
    {
        return view('choferes.show', compact('chofer'));
    }

    public function edit(Chofer $chofer)
    {
        return view('choferes.edit', compact('chofer'));
    }

    public function update(Request $request, Chofer $chofer)
    {
        $data = $request->validate([
            'numero'               => 'required|integer',
            'bus_codigo'           => 'required|string|max:10',
            'nombre_chofer'        => 'required|string|max:255',
            'licencia'             => 'required|string|max:50',
            'vencimiento_licencia' => 'required|date',
        ]);

        $chofer->update($data);

        return redirect()
            ->route('choferes.index')
            ->with('success', 'Chofer actualizado correctamente.');
    }

    public function destroy(Chofer $chofer)
    {
        $chofer->delete();

        return redirect()
            ->route('choferes.index')
            ->with('success', 'Chofer eliminado correctamente.');
    }
}
