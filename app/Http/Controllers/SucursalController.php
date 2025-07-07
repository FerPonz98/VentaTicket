<?php
namespace App\Http\Controllers;
use App\Models\Sucursal;
use Illuminate\Http\Request;

class SucursalController extends Controller
{
   
    public function create()
    {
        return view('sucursales.create'); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Sucursal::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('dashboard')->with('success', 'Sucursal creada correctamente.');
    }

    public function dashboard()
    {
        $sucursales = \App\Models\Sucursal::all();
        $descuentos = \App\Models\Descuento::whereHas('viaje', function($q) {
            $q->whereDate('fecha_salida', '>=', now()->toDateString());
        })->with(['viaje.ruta'])->get();

        return view('admin.dashboard', compact('sucursales', 'descuentos'));
    }
}

