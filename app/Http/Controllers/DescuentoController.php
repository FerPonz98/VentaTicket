<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Descuento;
use App\Models\Viaje;
use Illuminate\Http\Request;

class DescuentoController extends Controller
{
    public function create()
    {
        $viajes = Viaje::all();
        return view('descuentos.create', compact('viajes'));
    }

    
public function store(Request $request)
{
    $request->validate([
        'viaje_id' => 'required|exists:viajes,id',
        'valor_descuento' => 'required|numeric|min:0',
        'tipo_descuento' => 'required|in:valor,porcentaje',
    ]);

    $descuentoCount = Descuento::where('viaje_id', $request->viaje_id)->count();
    if ($descuentoCount >= 2) {
        return back()->withErrors(['viaje_id' => 'Este viaje ya tiene dos descuentos registrados.']);
    }

    $codigo_descuento = 'DESC' . strtoupper(Str::random(8));

    $descuento = Descuento::create([
        'viaje_id' => $request->viaje_id,
        'valor_descuento' => $request->valor_descuento,
        'tipo_descuento' => $request->tipo_descuento,
        'codigo_descuento' => $codigo_descuento,
    ]);

    $viaje = Viaje::findOrFail($request->viaje_id);

    if ($descuento->tipo_descuento === 'porcentaje') {
        $descuento_aplicado = $viaje->precio * ($descuento->valor_descuento / 100);
        $viaje->precio -= $descuento_aplicado;
    } else {
        $viaje->precio -= $descuento->valor_descuento;
    }

    $viaje->save();

    return redirect()->route('descuentos.create')->with('success', 'Descuento creado y aplicado correctamente. Código de descuento: ' . $codigo_descuento);
}
}
