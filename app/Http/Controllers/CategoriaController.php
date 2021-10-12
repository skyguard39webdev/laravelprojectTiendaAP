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

    public function showEditarCategoria()
    {
        $categorias = Categoria::query()->get();

        return view('editarcategoria', compact('categorias'));
    }

    public function confirmarEditarCategoria(Request $request)
    {
        $categoria = Categoria::findOrFail($request->categoria_id);
        $categoria->nombre = $request->nombre;
        $checksave = $categoria->save();

        if ($checksave) {
            return back()->with('successUpdating', 'El nombre de la categoría ha sido actualizado con exito.');
        } else {
            App::abort(500, 'Error de servidor');
        }
    }
}
