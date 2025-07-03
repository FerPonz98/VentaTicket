<?php

namespace App\Http\Controllers;

use App\Models\Encomienda;
use App\Models\EncomiendaItem;
use App\Models\Viaje;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class EncomiendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Encomienda::with(['viaje.bus', 'cajero', 'items'])
            ->when($request->query('encomienda_id'), fn($q, $id) =>
                $q->where('id', $id)
            )
            ->orderByDesc('created_at');

        $encomiendas = $query->paginate(10)->withQueryString();

        return view('encomiendas.index', compact('encomiendas'));
    }

    public function create()
    {
    
        $viajes = Viaje::whereDate('fecha_salida', '>=', now()->toDateString())->get();

        return view('encomiendas.create', compact('viajes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'viaje_id'               => 'required|exists:viajes,id',
            'fecha'                  => 'required|date',
            'horario'                => 'required|date_format:H:i',
            'hora_recepcion'         => 'required|date_format:H:i',
            'estado'                 => 'required|in:por_pagar,pagado',
            'cajero_id'              => 'required|exists:usuarios,ci_usuario',

            'remitente_id'           => 'required|string|max:50',
            'remitente_nombre'       => 'required|string|max:255',
            'remitente_telefono'     => 'required|string|max:20',

            'consignatario_nombre'   => 'required|string|max:255',
            'consignatario_ci'       => 'required|string|max:50',
            'consignatario_telefono' => 'required|string|max:20',

            'items'                  => 'required|array|min:1',
            'items.*.cantidad'       => 'required|integer|min:1',
            'items.*.descripcion'    => 'required|string',
            'items.*.peso'           => 'required|numeric|min:0.01',
            'items.*.costo'          => 'required|numeric|min:0',
        ]);

        $data['guia_numero']   = 'E'.now()->format('YmdHis');
        $data['es_carga']      = false;
        $data['cajero_id']     = Auth::user()->ci_usuario;

        $encomienda = Encomienda::create(Arr::only($data, [
            'viaje_id','guia_numero','estado','fecha','horario','hora_recepcion',
            'remitente_id','remitente_nombre','remitente_telefono',
            'consignatario_nombre','consignatario_ci','consignatario_telefono',
            'cajero_id','es_carga',
        ]));

        foreach ($data['items'] as $item) {
            $encomienda->items()->create($item);
        }

        return redirect()
            ->route('encomiendas.index')
            ->with('success', 'Encomienda creada correctamente.');
    }

    public function show(Encomienda $encomienda)
    {
        $encomienda->load(['viaje.ruta', 'viaje.bus', 'cajero', 'items']);
        return view('encomiendas.show', compact('encomienda'));
    }

    public function edit(Encomienda $encomienda)
    {
        $viajes = Viaje::with(['ruta','bus'])
                       ->whereDate('fecha_salida', '>=', now()->toDateString())
                       ->orderBy('fecha_salida')
                       ->get();
        $encomienda->load('items');
        return view('encomiendas.edit', compact('encomienda','viajes'));
    }

    public function update(Request $request, Encomienda $encomienda)
    {
        $data = $request->validate([
            'viaje_id'               => 'required|exists:viajes,id',
            'fecha'                  => 'required|date',
            'horario'                => 'required|date_format:H:i',
            'hora_recepcion'         => 'required|date_format:H:i',
            'estado'                 => 'required|in:por_pagar,pagado',

            'remitente_id'           => 'required|string|max:50',
            'remitente_nombre'       => 'required|string|max:255',
            'remitente_telefono'     => 'required|string|max:20',

            'consignatario_nombre'   => 'required|string|max:255',
            'consignatario_ci'       => 'required|string|max:50',
            'consignatario_telefono' => 'required|string|max:20',

            'items'                  => 'required|array|min:1',
            'items.*.cantidad'       => 'required|integer|min:1',
            'items.*.descripcion'    => 'required|string',
            'items.*.peso'           => 'required|numeric|min:0.01',
            'items.*.costo'          => 'required|numeric|min:0',
        ]);

        $encomienda->update(Arr::only($data, [
            'viaje_id','estado','fecha','horario','hora_recepcion',
            'remitente_id','remitente_nombre','remitente_telefono',
            'consignatario_nombre','consignatario_ci','consignatario_telefono'
        ]));

        $encomienda->items()->delete();
        foreach ($data['items'] as $item) {
            $encomienda->items()->create($item);
        }

        return redirect()
            ->route('encomiendas.index')
            ->with('success', 'Encomienda actualizada correctamente.');
    }

    public function destroy(Encomienda $encomienda)
    {
        $encomienda->items()->delete();
        $encomienda->delete();

        return redirect()
            ->route('encomiendas.index')
            ->with('success', 'Encomienda eliminada correctamente.');
    }
    public function pdf(Encomienda $encomienda)
    {
        $encomienda->load([
            'cajero',
            'items',
            'viaje.bus',
            'viaje.ruta',
        ]);
    
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('encomiendas.pdf', compact('encomienda'))
            ->setPaper([0, 0, 226.77, 841.89], 'portrait');

        return $pdf->stream("Encomienda_{$encomienda->guia_numero}.pdf");
    }
    
    

}