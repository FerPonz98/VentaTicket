<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chofer;
use App\Models\Kardex;
class KardexController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        if ($user->rol === 'chofer' || $user->rol === 'ayudante') {
            $chofer = Chofer::where('CI', $user->ci_usuario)->first();
    
            if (!$chofer) {
                abort(403, 'Chofer no encontrado.');
            }

            $kardex = Kardex::where('chofer_ci', $chofer->CI)->get();
    
            return view('kardex.index', compact('chofer', 'kardex'));
        }
    
        abort(403, 'Rol no autorizado.');
    }
}
