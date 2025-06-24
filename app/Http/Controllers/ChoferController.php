<?php
// app/Http/Controllers/ChoferController.php
namespace App\Http\Controllers;

use App\Models\Chofer;
use App\Models\Bus;
use Illuminate\Http\Request;

class ChoferController extends Controller
{
    public function index()
    {
        $choferes = Chofer::with('bus')->get();
        return view('choferes.index', compact('choferes'));
    }

    public function create()
    {
        $buses = Bus::pluck('codigo','id');
        return view('choferes.create', compact('buses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'bus_id'               => 'required|exists:buses,id',
            'nombre_chofer'        => 'required|string|max:100',
            'licencia'             => 'required|string|max:50',
            'vencimiento_licencia' => 'required|date',
            'nombre_ayudante'      => 'nullable|string|max:100',
        ]);
        Chofer::create($data);
        return redirect()->route('choferes.index')->with('success','Chofer creado.');
    }

    public function edit(Chofer $chofer)
    {
        $buses = Bus::pluck('codigo','id');
        return view('choferes.edit', compact('chofer','buses'));
    }

    public function update(Request $request, Chofer $chofer)
    {
        $data = $request->validate([
            'bus_id'               => 'required|exists:buses,id',
            'nombre_chofer'        => 'required|string|max:100',
            'licencia'             => 'required|string|max:50',
            'vencimiento_licencia' => 'required|date',
            'nombre_ayudante'      => 'nullable|string|max:100',
        ]);
        $chofer->update($data);
        return redirect()->route('choferes.index')->with('success','Chofer actualizado.');
    }

    public function destroy(Chofer $chofer)
    {
        $chofer->delete();
        return redirect()->route('choferes.index')->with('success','Chofer eliminado.');
    }
}
