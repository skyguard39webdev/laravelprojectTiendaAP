<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use Illuminate\Http\Request;

class SubcategoriaController extends Controller
{
    public function nuevaSubCat()
    {
        return view('nuevasubcategoria');
    }

    public function ingresarSubCat(Request $request)
    {
        $subcategoria = new Subcategoria;
        $subcategoria->nombre = $request->nombre;
        $subcategoria->cat_id = $request->categoria;
        $checksave = $subcategoria->save();
        
        if (!$checksave){
            App::abort(500, 'Error');
        }else {
            return redirect('/nueva-subcat')->with('success', 'Se ha guardado la nueva Subcategoria con exito.');
        }
    }

    public function showEditarSubcategoria()
    {
        $subcategorias = Subcategoria::query()->get();

        return view('editarsubcategoria', compact('subcategorias'));
    }

    public function confirmarEditarSubcategoria(Request $request)
    {
        $subcategoria = Subcategoria::findOrFail($request->subcategoria_id);
        $subcategoria->nombre = $request->nombre;
        $checksave = $subcategoria->save();

        if ($checksave) {
            return back()->with('successUpdating', 'El nombre de la categoría ha sido actualizado con exito.');
        } else {
            App::abort(500, 'Error de servidor');
        }
    }
}
