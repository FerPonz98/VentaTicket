<?php

namespace App\Http\Controllers;

use App\Models\Carga;
use App\Models\Viaje;
use App\Models\Turno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CargaController extends Controller
{

    public function index(Request $request)
    {
        $busFilter = $request->query('bus');

        $query = Carga::with(['cajero', 'detalles', 'viaje.bus'])
            ->when($busFilter, fn($q) =>
                $q->whereHas('viaje.bus', fn($qb) =>
                    $qb->where('codigo', 'like', "%{$busFilter}%")
                )
            )
            ->orderByDesc('created_at');

        $cargas = $query->paginate(10, ['*'], 'cargas_page');

        return view('cargas.index', compact('cargas', 'busFilter'));    }

    public function create()
    {
        $viajes = Viaje::with('ruta')
            ->whereDate('fecha_salida', '>=', now()->toDateString())
            ->orderBy('fecha_salida', 'desc')
            ->get();
        return view('cargas.create', compact('viajes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'viaje_id'            => 'required|exists:viajes,id',
            'origen'              => 'required|string',
            'destino'             => 'required|string',
            'fecha'               => 'required|date',
            'horario'             => 'required|date_format:H:i',
            'hora_recepcion'      => 'nullable|date_format:H:i',
            'estado'              => 'required|in:por pagar,pagado',
            'remitente_nombre'    => 'required|string|max:255',
            'remitente_ci'        => 'required|string|max:50',
            'remitente_telefono'  => 'required|string|max:20',
            'detalles'            => 'required|array|min:1',
            'detalles.*.cantidad'    => 'required|integer|min:1',
            'detalles.*.descripcion' => 'required|string',
            'detalles.*.peso'        => 'required|numeric|min:0.01',
            'detalles.*.costo'       => 'required|numeric|min:0',
        ]);

        $viaje = Viaje::findOrFail($validated['viaje_id']);
        if (\Carbon\Carbon::parse($viaje->fecha_salida)->lt(now()->startOfDay())) {
            return back()->withInput()->withErrors(['viaje_id' => 'No se puede registrar carga para un viaje en el pasado.']);
        }

        $turno = Turno::firstOrCreate(
            ['cajero_id' => Auth::user()->ci_usuario, 'fecha_fin' => null],
            ['fecha_inicio' => now()]
        );

        $validated['nro_guia']  = 'C' . now()->format('YmdHis');
        $validated['cajero_id'] = Auth::user()->ci_usuario;
        $validated['turno_id']  = $turno->id;

        $carga = Carga::create($validated);

        $totalCost = 0;
        foreach ($validated['detalles'] as $item) {
            $detalle = $carga->detalles()->create($item);
            $totalCost += $detalle->costo;
        }

        $turno->increment('total_pagado', $totalCost);

        return redirect()
            ->route('carga.index')
            ->with('success', 'Guía de carga creada correctamente.');
    }

 
    public function show(Carga $carga)
    {
        $carga->load(['cajero', 'detalles', 'viaje.bus']);
        return view('cargas.show', compact('carga'));
    }

    public function edit(Carga $carga)
    {
        $carga->load('detalles');
        $viajes = Viaje::with('ruta')
            ->whereDate('fecha_salida', '>=', now()->toDateString())
            ->orderBy('fecha_salida', 'desc')
            ->get();
        return view('cargas.edit', compact('carga', 'viajes'));
    }

    public function update(Request $request, Carga $carga)
    {
        $validated = $request->validate([
            'viaje_id'            => 'required|exists:viajes,id',
            'origen'              => 'required|string',
            'destino'             => 'required|string',
            'fecha'               => 'required|date',
            'horario'             => 'required|date_format:H:i',
            'hora_recepcion'      => 'nullable|date_format:H:i',
            'estado'              => 'required|in:por pagar,pagado',
            'remitente_nombre'    => 'required|string|max:255',
            'remitente_ci'        => 'required|string|max:50',
            'remitente_telefono'  => 'required|string|max:20',
            'detalles'            => 'required|array|min:1',
            'detalles.*.cantidad'    => 'required|integer|min:1',
            'detalles.*.descripcion' => 'required|string',
            'detalles.*.peso'        => 'required|numeric|min:0.01',
            'detalles.*.costo'       => 'required|numeric|min:0',
        ]);

        $oldTotal = $carga->detalles->sum('costo');

        $carga->update([
            'viaje_id'          => $validated['viaje_id'],
            'origen'            => $validated['origen'],
            'destino'           => $validated['destino'],
            'fecha'             => $validated['fecha'],
            'horario'           => $validated['horario'],
            'hora_recepcion'    => $validated['hora_recepcion'],
            'estado'            => $validated['estado'],
            'remitente_nombre'  => $validated['remitente_nombre'],
            'remitente_ci'      => $validated['remitente_ci'],
            'remitente_telefono'=> $validated['remitente_telefono'],
        ]);

        $carga->detalles()->delete();
        $newTotal = 0;
        foreach ($validated['detalles'] as $item) {
            $detalle = $carga->detalles()->create($item);
            $newTotal += $detalle->costo;
        }

        $turno = $carga->turno;
        if ($turno) {
            $turno->increment('total_pagado', $newTotal - $oldTotal);
        }

        return redirect()
            ->route('carga.index')
            ->with('success', 'Guía de carga actualizada correctamente.');
    }

   
    public function destroy(Carga $carga)
    {
       
        if ($carga->turno) {
            $carga->turno->decrement('total_pagado', $carga->detalles->sum('costo'));
        }

        $carga->delete();

        return redirect()
            ->route('carga.index')
            ->with('success', 'Guía de carga eliminada.');
    }

    public function pdf(Carga $carga)
    {
        $carga->load(['cajero', 'detalles', 'viaje.bus']);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('cargas.pdf', compact('carga'))
            ->setPaper([0,0,226.77,841.89], 'portrait');
        return $pdf->stream("Guia_Carga_{$carga->nro_guia}.pdf");
    }
}