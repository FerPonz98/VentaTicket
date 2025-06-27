<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Ruta;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['ruta','origenStop','destinoStop'])->paginate(15);
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $rutas = Ruta::with('stops')->get();
        $tipos = [
            'normal'       => 'Normal',
            '3ra_edad'     => '3ra Edad',
            'discapacidad' => 'Discapacidad',
            'cortesia'     => 'Cortesía',
        ];
        return view('tickets.create', compact('rutas','tipos'));
    }

    public function store(Request $request)
    {
        $v = $request->validate([
            'ruta_id'       => 'required|exists:rutas,id',
            'origen_id'     => 'required|exists:stops,id',
            'destino_id'    => 'required|exists:stops,id',
            'tipo_pasajero' => 'required|in:normal,3ra_edad,discapacidad,cortesia',
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

        $tramo = $stops->slice($origenIdx, $destinoIdx - $origenIdx + 1);
        $precioBase = 0;
        for ($i = 0; $i < $tramo->count() - 1; $i++) {
            $precioBase += $tramo[$i+1]->pivot->precio_parada;
        }

        $ruta = Ruta::find($v['ruta_id']);
        $descuento = match($v['tipo_pasajero']) {
            '3ra_edad'     => $ruta->precio_3ra_edad,
            'discapacidad' => $ruta->precio_discapacidad,
            'cortesia'     => $ruta->precio_cortesia,
            default        => 0,
        };
        $precioFinal = max(0, $precioBase - $descuento);

        $ticket = Ticket::create([
            'ruta_id'       => $v['ruta_id'],
            'origen_id'     => $v['origen_id'],
            'destino_id'    => $v['destino_id'],
            'tipo_pasajero' => $v['tipo_pasajero'],
            'precio'        => $precioFinal,
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['ruta','origenStop','destinoStop']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $rutas = Ruta::with('stops')->get();
        $tipos = [
            'normal'       => 'Normal',
            '3ra_edad'     => '3ra Edad',
            'discapacidad' => 'Discapacidad',
            'cortesia'     => 'Cortesía',
        ];
        return view('tickets.edit', compact('ticket','rutas','tipos'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $v = $request->validate([
            'ruta_id'       => 'required|exists:rutas,id',
            'origen_id'     => 'required|exists:stops,id',
            'destino_id'    => 'required|exists:stops,id',
            'tipo_pasajero' => 'required|in:normal,3ra_edad,discapacidad,cortesia',
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

        $tramo = $stops->slice($origenIdx, $destinoIdx - $origenIdx + 1);
        $precioBase = 0;
        for ($i = 0; $i < $tramo->count() - 1; $i++) {
            $precioBase += $tramo[$i+1]->pivot->precio_parada;
        }

        $ruta = Ruta::find($v['ruta_id']);
        $descuento = match($v['tipo_pasajero']) {
            '3ra_edad'     => $ruta->precio_3ra_edad,
            'discapacidad' => $ruta->precio_discapacidad,
            'cortesia'     => $ruta->precio_cortesia,
            default        => 0,
        };
        $precioFinal = max(0, $precioBase - $descuento);

        $ticket->update([
            'ruta_id'       => $v['ruta_id'],
            'origen_id'     => $v['origen_id'],
            'destino_id'    => $v['destino_id'],
            'tipo_pasajero' => $v['tipo_pasajero'],
            'precio'        => $precioFinal,
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index');
    }
}
