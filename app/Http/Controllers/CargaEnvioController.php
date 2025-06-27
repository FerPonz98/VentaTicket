<?php

namespace App\Http\Controllers;

use App\Models\CargaEnvio;
use App\Models\Ruta;
use Illuminate\Http\Request;

class CargaEnvioController extends Controller
{
    public function index()
    {
        $cargas = CargaEnvio::with(['ruta','origenStop','destinoStop'])->paginate(15);
        return view('cargaenvios.index', compact('cargas'));
    }

    public function create()
    {
        $rutas = Ruta::with('stops')->get();
        return view('cargaenvios.create', compact('rutas'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'ruta_id'    => 'required|exists:rutas,id',
            'origen_id'  => 'required|exists:stops,id',
            'destino_id' => 'required|exists:stops,id',
            'peso'       => 'required|numeric|min:0',
            'volumen'    => 'required|numeric|min:0',
            'precio'     => 'required|numeric|min:0',
        ]);

        $stops = Ruta::findOrFail($v['ruta_id'])
            ->stops()
            ->orderBy('pivot_sequence')
            ->get();
        $origenIdx  = $stops->search(fn($s) => $s->id == $v['origen_id']);
        $destinoIdx = $stops->search(fn($s) => $s->id == $v['destino_id']);

        if ($origenIdx === false || $destinoIdx === false || $destinoIdx <= $origenIdx) {
            return back()->withInput()->withErrors([
                'destino_id' => 'El destino debe estar después del origen en la misma ruta.'
            ]);
        }

        $carga = CargaEnvio::create($v);

        return redirect()->route('cargaenvios.show', $carga);
    }

    public function show(CargaEnvio $carga)
    {
        $carga->load(['ruta','origenStop','destinoStop']);
        return view('cargaenvios.show', compact('carga'));
    }

    public function edit(CargaEnvio $carga)
    {
        $rutas = Ruta::with('stops')->get();
        return view('cargaenvios.edit', compact('carga','rutas'));
    }

    public function update(Request $request, CargaEnvio $carga)
    {
        $v = $request->validate([
            'ruta_id'    => 'required|exists:rutas,id',
            'origen_id'  => 'required|exists:stops,id',
            'destino_id' => 'required|exists:stops,id',
            'peso'       => 'required|numeric|min:0',
            'volumen'    => 'required|numeric|min:0',
            'precio'     => 'required|numeric|min:0',
        ]);

        $stops = Ruta::findOrFail($v['ruta_id'])
            ->stops()
            ->orderBy('pivot_sequence')
            ->get();
        $origenIdx  = $stops->search(fn($s) => $s->id == $v['origen_id']);
        $destinoIdx = $stops->search(fn($s) => $s->id == $v['destino_id']);

        if ($origenIdx === false || $destinoIdx === false || $destinoIdx <= $origenIdx) {
            return back()->withInput()->withErrors([
                'destino_id' => 'El destino debe estar después del origen en la misma ruta.'
            ]);
        }

        $carga->update($v);

        return redirect()->route('cargaenvios.show', $carga);
    }

    public function destroy(CargaEnvio $carga)
    {
        $carga->delete();
        return redirect()->route('cargaenvios.index');
    }
}
