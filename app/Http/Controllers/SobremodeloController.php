<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sobremodelo;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
// use Request;

class SobremodeloController extends Controller
{
    public function index()
    {

        // dd(Sobremodelo::select('oculto')->get()->all()[0]->oculto);
        // $subcategorias = Subcategoria::get()->all();

        $producto = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('productos.oculto', 0)
            ->where('sobremodelos.oculto', 0)
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->paginate(12);

        // $agregados = Sobremodelo::latest()->where('oculto', 0)->limit(4)->get();
        $agregados = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto', 'sobremodelos.created_at')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('sobremodelos.destacado', 1)
            ->where('sobremodelos.oculto', 0)
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->latest()
            ->limit(12)
            ->get();

        // $actualizados = Sobremodelo::where('oculto', 0)->orderBy('updated_at', 'desc')->limit(4)->get();
        $actualizados = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto', 'sobremodelos.updated_at')
        ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
        ->where('productos.oculto', 0)
        ->where('sobremodelos.oculto', 0)
        ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
        ->orderBy('updated_at', 'desc')
        ->limit(4)
        ->get();

        // esta funcion agarra los diferentes valores en sobremodelo
        // es importante decirle al select que hay que traer de modelo porque sino no trae nada mas que lo solicitado en el select
        // $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->distinct()->get();
        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->where('oculto', 0)->distinct()->get();


        // dd(array_column($imgModelos->all(), 'sobremodelo_id'));
        // dd(array_count_values(array_column($producto->producto->all(), 'sobremodelo_id')));
        // dd(Request::all()[0]);
        // dd($imgModelos->all()[0]->oculto);
        // dd($imgModelos->all()[0]->sobremodelo->titulo);
        // dd(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[2]);
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
        $sobremodelo->oculto = 0;
        $sobremodelo->destacado = 0;
        $checksave = $sobremodelo->save();
        
        // chequea si la base de datos realmente salva o no
        if (!$checksave){
            App::abort(500, 'Error');
        }else {
            return redirect('/nuevo-sobremodelo')->with('exitoSobremodelo', 'Se ha guardado la nueva tarjeta con exito.');
        }
    }

    public function confirmarEliminarSobremodelo(Request $request)
    {   
        if( !empty(Producto::where('sobremodelo_id', $request->sobremodelo_id)->get()->all()) ) {
            return back()->with('errorDeleating', 'La tarjeta asociada no ha podido ser eliminada. Aun tiene productos asociados (Sugerencia: mover los productos a otra tarjeta).');
        } else {
            Sobremodelo::where('id', $request->sobremodelo_id)->delete();
            return back()->with('successDeleating', 'La tarjeta se ha eliminado correctamente.');
        }
    }

    public function showEliminarSobremodelo()
    {
        $sobremodelos = Sobremodelo::query()->get();

        return view('eliminarsobremodelo', compact('sobremodelos'));
    }

    public function estadoSelect(Request $request)
    {
        $listaSobremodelos = Sobremodelo::query()->where('oculto', $request->estado)->paginate(400); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('ocultarmostrar-sobremodelos', compact('listaSobremodelos'));
            // return redirect('/lista-sobremodelos', compact('listaSobremodelos'));
        }
        else {
            return redirect('/');
        }
    }

    public function estadoUpdateSobremodelo(Request $request)
    {
        $checksave = FALSE;
        $index = 0;
        foreach ($request->all()['id'] as $rid) {
            $sobremodelo = Sobremodelo::findOrFail($rid);
            $sobremodelo->oculto = $request->all()['estado'][$index];
            $checksave = $sobremodelo->save();
            $index++;
            
        }
        if ($checksave) {
            return redirect('/lista-sobremodelos')->with('exitoUpdateEstado', 'Los estados han sido actualizados con exito.');
        } else {
            App::abort(500, 'Error');
        }
    }

    public function showListaSobremodelos()
    {
        $listaSobremodelos = Sobremodelo::query()->paginate(400); // con limite de 400 evitamos generar un bug del kernel de php

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('ocultarmostrar-sobremodelos', compact('listaSobremodelos'));
        }
        else {
            return redirect('/');
        }
    }
    
    public function showEditarSobremodelo()
    {
        $sobremodelos = Sobremodelo::query()->get();

        return view('editarsobremodelo', compact('sobremodelos'));
    }

    public function confirmarEditarSobremodelo(Request $request)
    {
        $sobremodelo = Sobremodelo::findOrFail($request->sobremodelo_id);
        $sobremodelo->titulo = $request->titulo;
        $checksave = $sobremodelo->save();

        if ($checksave) {
            return back()->with('successUpdating', 'El titulo de la tarjeta ha sido actualizado con exito.');
        } else {
            App::abort(500, 'Error de servidor');
        }
    }
}
