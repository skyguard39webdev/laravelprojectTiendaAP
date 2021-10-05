<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sobremodelo;
use App\Models\Producto;
// use Request;

class SobremodeloController extends Controller
{
    public function index()
    {
        // $subcategorias = Subcategoria::get()->all();

        $producto = Sobremodelo::query()->paginate(12);

        $agregados = Sobremodelo::latest()->limit(4)->get();

        $actualizados = Sobremodelo::orderBy('updated_at', 'desc')->limit(4)->get();

        // esta funcion agarra los diferentes valores en sobremodelo
        // es importante decirle al select que hay que traer de modelo porque sino no trae nada mas que lo solicitado en el select
        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio')->distinct()->get();

        // dd(array_column($imgModelos->all(), 'sobremodelo_id'));
        // dd(array_count_values(array_column($producto->producto->all(), 'sobremodelo_id')));
        // dd(Request::all()[0]);

        // dd($imgModelos->all()[0]->sobremodelo->titulo);
        // dd($imgModelos->all()[0]->modelo);
        // dd( array_column($producto->all()[0]->producto->get()->all(), 'precio') );

        return view('producto', compact('producto', 'agregados', 'actualizados', 'imgModelos'));
    }

    public function nuevoSobremodelo()
    {
        return view('nuevosobremodelo');
    }

    public function ingresarSobremodelo(Request $request)
    {
        $sobremodelo = new Sobremodelo;
        $sobremodelo->titulo = $request->titulo;
        $checksave = $sobremodelo->save();
        
        // chequea si la base de datos realmente salva o no
        if (!$checksave){
            App::abort(500, 'Error');
        }else {
            return redirect('/nuevo-sobremodelo')->with('exitoSobremodelo', 'Se ha guardado el nuevo Sobremodelo con exito.');
        }
    }

    public function confirmarEliminarSobremodelo(Request $request)
    {   
        if( !empty(Producto::where('sobremodelo_id', $request->sobremodelo_id)->get()->all()) ) {
            return back()->with('errorDeleating', 'El sobremodelo asociado no ha podido ser eliminado.');
        } else {
            Sobremodelo::where('id', $request->sobremodelo_id)->delete();
            return back()->with('successDeleating', 'El sobremodelo asociado se ha eliminado correctamente.');
        }
    }

    public function showEliminarSobremodelo()
    {
        $sobremodelos = Sobremodelo::query()->get();

        return view('eliminarsobremodelo', compact('sobremodelos'));
    }
}
