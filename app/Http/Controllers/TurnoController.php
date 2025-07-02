<?php
// app/Http/Controllers/TurnoController.php
namespace App\Http\Controllers;

use App\Models\Turno;
use Illuminate\Support\Facades\Auth;

class TurnoController extends Controller
{
    // Ver todos los turnos del cajero
    public function index()
    {
        $turnos = Turno::where('cajero_id', Auth::user()->ci_usuario)
                       ->orderByDesc('fecha_inicio')
                       ->get();
        return view('turnos.index', compact('turnos'));
    }

    // Cerrar un turno abierto
    public function close(Turno $turno)
    {
        $this->authorize('update', $turno); 
        $turno->update(['fecha_fin' => now()]);
        return back()->with('success','Turno cerrado correctamente.');
    }
}
