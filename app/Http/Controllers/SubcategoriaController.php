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
}
