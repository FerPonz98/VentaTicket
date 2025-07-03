<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChoferController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
    
        if ($user->rol === 'chofer') {
 
            $choferes = Chofer::where('CI', $user->ci_usuario)->get();
        } else {
            $choferes = Chofer::all();
        }
    
        return view('choferes.index', compact('choferes'));
    }
    

    public function show(Chofer $chofer)
    {
        $user = Auth::user();

        if ($user->rol === 'chofer' && $chofer->CI !== $user->ci_usuario) {
            abort(403);
        }
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc','chofer'])) {
            abort(403);
        }

        return view('choferes.show', compact('chofer'));
    }

    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc'])) {
            abort(403);
        }
        return view('choferes.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc'])) {
            abort(403);
        }

        $data = $request->validate([
            'CI'                   => 'required|string|unique:choferes,CI',
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

    public function edit(Chofer $chofer)
    {
        $user = Auth::user();
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc'])) {
            abort(403);
        }
        return view('choferes.edit', compact('chofer'));
    }

    public function update(Request $request, Chofer $chofer)
    {
        $user = Auth::user();
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc'])) {
            abort(403);
        }

        $data = $request->validate([
            'CI'                   => "required|string|unique:choferes,CI,{$chofer->CI},CI",
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
        $user = Auth::user();
        if (!in_array($user->rol, ['admin','supervisor gral','supervisor suc'])) {
            abort(403);
        }

        // Desasociar el chofer de los buses antes de eliminarlo
        \App\Models\Bus::where('chofer_id', $chofer->CI)->update(['chofer_id' => null]);

        $chofer->delete();

        return redirect()
            ->route('choferes.index')
            ->with('success', 'Chofer eliminado correctamente.');
    }
}
