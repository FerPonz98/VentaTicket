<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', ['user'=>Auth::user()]);
    }

    public function update(Request $r)
    {
        $u = Auth::user();
        $data = $r->validate([
            'nombre_usuario'=>'required|string',
            'nombre'=>'nullable|string',
            'apellidos'=>'nullable|string',
            'email'=>'required|email',
            'password'=>'nullable|confirmed|min:8'
        ]);
        if($data['password']??false){
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
        }
        $u->update($data);
        return back()->with('success','Perfil actualizado.');
    }
}
