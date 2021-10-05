<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use App;

class CategoriaController extends Controller
{
    public function nuevaCat()
    {
        return view('nuevacategoria');
    }

    public function ingresarCat(Request $request)
    {
        $categoria = new Categoria;
        $categoria->nombre = $request->nombre;
        $checksave = $categoria->save();
        
        // chequea si la base de datos realmente salva o no
        if (!$checksave){
            App::abort(500, 'Error');
        }else {
            return redirect('/nueva-cat')->with('success', 'Se ha guardado la nueva Categoria con exito.');
        }
    }
}
