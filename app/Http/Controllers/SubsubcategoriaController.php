<?php

namespace App\Http\Controllers;

use App\Models\Subsubcategoria;
use Illuminate\Http\Request;
use App\Models\Producto;

class SubsubcategoriaController extends Controller
{
    public function nuevaSubsubCat()
    {
        return view('nuevasubsubcategoria');
    }

    public function ingresarSubsubCat(Request $request)
    {
        $subsubcategoria = new Subsubcategoria;
        $subsubcategoria->nombre = $request->nombre;
        if($request->subsubcategoria == null) {
            return back()->with('nullsubsubcategoria', 'No ha seleccionado un subsubcategoria.');
        }
        $subsubcategoria->subcat_id = $request->subsubcategoria;
        $checksave = $subsubcategoria->save();
        
        if (!$checksave){
            App::abort(500, 'Error');
        }else {
            return redirect('/nueva-subsubcat')->with('success', 'Se ha guardado la nueva Subsubcategoria con exito.');
        }
    }

    public function showEditarSubsubcategoria()
    {
        $subsubcategorias = Subsubcategoria::query()->get();

        return view('editarsubsubcategoria', compact('subsubcategorias'));
    }

    public function confirmarEditarSubsubcategoria(Request $request)
    {
        $subsubcategoria = Subsubcategoria::findOrFail($request->subsubcategoria_id);
        $subsubcategoria->nombre = $request->nombre;
        $checksave = $subsubcategoria->save();

        if ($checksave) {
            return back()->with('successUpdating', 'El nombre de la Subsubcategoría ha sido actualizado con exito.');
        } else {
            App::abort(500, 'Error de servidor');
        }
    }

    public function showEliminarSubsubcategoria()
    {
        $subsubcategorias = Subsubcategoria::query()->get();

        return view('eliminarsubsubcategoria', compact('subsubcategorias'));
    }

    public function confirmarEliminarSubsubcategoria(Request $request)
    {   
        if( !empty(Producto::where('subsubcategoria_id', $request->subsubcategoria)->get()->all())) {
            return back()->with('errorDeleating', 'La subsubcategoria asociada no ha podido ser eliminada. Aun tiene productos asociados.');
        } else {
            Subsubcategoria::where('id', $request->subsubcategoria)->delete();
            return back()->with('successDeleating', 'La subsubcategoria se ha eliminado correctamente.');
        }
    }
}
