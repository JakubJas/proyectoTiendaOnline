<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UsuarioController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'usuario' => 'required',
            'clave' => 'required',
        ]);

        $usuario = Usuario::where('usuario', $request->input('usuario'))->first();

        if ($usuario && $usuario->clave === $request->input('clave')) {

            Session::put('usuario_id', $usuario->id);
            return redirect()->route('priv');
        }else{
            $mensaje = "Usuario y contraseña inválidos";
            return view('login', compact("mensaje"));
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

}
