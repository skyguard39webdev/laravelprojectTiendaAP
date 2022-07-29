<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UsuarioController extends Controller
{
    public function index()
    {

        $usuario = User::query()->paginate(400); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('lista-usuarios', compact('usuario'));
        }
        else {
            return redirect('/');
        }
    }
    
    public function rolSelect(Request $request)
    {   
        if ($request->rol == 0) {
            return redirect('/lista-usuarios')->with('errorBusquedaRol', 'Debe seleccionar un rol de usuario valido.');
        }
        

        $usuario = User::query()->where('rol_id', $request->rol)->paginate(50); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('lista-usuarios', compact('usuario'));
        }
        else {
            return redirect('/');
        }
    }

    public function rolUpdate(Request $request)
    {
        $checksave = FALSE;
        $index = 0;
        foreach ($request->all()['id'] as $rid) {
            $usuario = User::findOrFail($rid);
            $usuario->rol_id = $request->all()['rol'][$index];
            $checksave = $usuario->save();
            $index++;
            
        }
        if ($checksave) {
            return redirect('/lista-usuarios')->with('exitoUpdateRol', 'Los roles han sido actualizados con exito.');
        } else {
            App::abort(500, 'Error');
        }
    }
}
