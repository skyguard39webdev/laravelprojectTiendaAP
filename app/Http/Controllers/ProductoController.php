<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Subcategoria;
use App\Models\Producto;
use App\Models\Carro;
use App\Models\Sobremodelo;

class ProductoController extends Controller
{
    public function index()
    {
        // $subcategorias = Subcategoria::get()->all();
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        $producto = Producto::query()->paginate(12);

        $agregados = Producto::latest()->limit(4)->get();

        $actualizados = Producto::orderBy('updated_at', 'desc')->limit(4)->get();
        

        return view('producto', compact('producto', 'agregados', 'actualizados'));
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA
        // DEPRECATED POR AHORA NO SE USA

    }

    public function cat($cat)
    {
        // ESTO AL PARECER RECOJE LOS PRODUCTOS DE LA CATEGORIA CORRECTA SIN REPETIRSE
        // WOOOOOOOOOOOOOOOOOOOOOOOW HOW THE FUCK IT IS WORKING, I DON'T KNOW, DON'T ASK ME
        $producto = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('productos.subcategoria_id', $cat)
            // ->distinct()
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->paginate(12);
            
        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio')
            ->where('subcategoria_id', $cat)
            ->distinct()
            ->get();


        // dd($producto->all());
        // dd($producto[0]);

        return view('productos.cat', compact('producto', 'imgModelos'));
    }

    // public function precioMayor($cat)
    // {
    //     $producto = Producto::where('subcategoria_id', $cat)->orderBy('precio', 'desc')->paginate(12);

    //     return view('productos.cat', compact('producto'));
    // }

    // public function precioMenor($cat)
    // {
    //     $producto = Producto::where('subcategoria_id', $cat)->orderBy('precio', 'asc')->paginate(12);

    //     return view('productos.cat', compact('producto'));
    // }

    public function idProd($id)
    {
        $producto = Producto::where('sobremodelo_id', $id)->get();
        
        $relacionado = explode(' ', $producto[0]->titulo, -1);

        if(empty($relacionado)) {
            $recomendados = Sobremodelo::latest()->limit(4)->get();
        }else {
            $recomendados = Sobremodelo::where('titulo', 'like', "%{$relacionado[0]}%")
                // ->orWhere('descripcion', 'like', "%{$relacionado[0]}%")
                // ->orWhere('marca', 'like', "%{$relacionado[0]}%")
                // ->orWhere('modelo', 'like', "%{$relacionado[0]}%")
                ->limit(4)
                ->get();
        }

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio')->distinct()->get();

        return view('detalle', compact('producto', 'recomendados', 'imgModelos'));
    }

    public function detalleextra($producto_id, $sobremodelo_id)
    {
        $producto = Producto::where('sobremodelo_id', $sobremodelo_id)->get();

        $main_producto = Producto::where('id', $producto_id)->get();
        
        $relacionado = explode(' ', $producto[0]->titulo, -1);

        if(empty($relacionado)) {
            $recomendados = Sobremodelo::latest()->limit(4)->get();
        }else {
            $recomendados = Sobremodelo::where('titulo', 'like', "%{$relacionado[0]}%")
                // ->orWhere('descripcion', 'like', "%{$relacionado[0]}%")
                // ->orWhere('marca', 'like', "%{$relacionado[0]}%")
                // ->orWhere('modelo', 'like', "%{$relacionado[0]}%")
                ->limit(4)
                ->get();
        }

        $imgModelos = Producto::select('modelo', 'sobremodelo_id')->distinct()->get();

        return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'main_producto'));
    }

    public function nuevoProducto()
    {
        $sobremodelos = Sobremodelo::get();

        return view('nuevoproducto', compact('sobremodelos'));
    }

    public function ingresarProducto(Request $request)
    {
        $producto = new Producto;
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->titulo = $request->titulo;
        $producto->precio = $request->precio;
        if($request->precio == null) {
            return back()->with('nullPrecio', 'No ha ingresado un Precio.');
        }elseif (!is_numeric($request->precio)){
            return back()->with('nanPrecio', 'No ha ingresado un valor correcto en el campo Precio.');
        }
        $producto->peso = $request->peso;
        $producto->tramos = $request->tramos;
        $producto->tramos_mts = $request->tmts;
        $producto->pcs = $request->pcs;
        $producto->subcategoria_id = $request->categoria;
        if($request->sobremodelo == null) {
            return back()->with('nullSobremodelo', 'No ha seleccionado un Sobremodelo.');
        }
        $producto->sobremodelo_id = $request->sobremodelo;
        $producto->descripcion = $request->descripcion;
        $producto->save();

        $nombreImagen = $request->modelo . '.' . $request->imagen->getClientOriginalExtension();
        $request->imagen->move(public_path('img'), $nombreImagen);

        return back()->with('exitoProducto', 'El nuevo producto ha sido agregado a la Base de datos exitosamente.');
    }

    public function updateProducto(Request $request)
    {
        $producto = Producto::findOrFail($request->id);
        $producto->marca = $request->marca;
        $producto->modelo = $request->modelo;
        $producto->titulo = $request->titulo;
        if($request->precio == null) {
            return back()->with('nullPrecio', 'No ha ingresado un Precio.');
        }elseif (!is_numeric($request->precio)){
            return back()->with('nanPrecio', 'No ha ingresado un valor correcto en el campo Precio.');
        }
        $producto->precio = $request->precio;
        $producto->peso = $request->peso;
        $producto->tramos = $request->tramos;
        $producto->tramos_mts = $request->tmts;
        $producto->pcs = $request->pcs;
        $producto->subcategoria_id = $request->categoria;
        if($request->sobremodelo == null) {
            return back()->with('nullSobremodelo', 'No ha seleccionado un Sobremodelo.');
        }
        $producto->sobremodelo_id = $request->sobremodelo;
        $producto->descripcion = $request->descripcion;
        $producto->save();

        // if($request->imagen == null){
        //     return back()->with('errorImagen', 'No se ha cargado una imagen.');
        // }
        // if ($request->imagen->getClientOriginalExtension() != 'jpg'){
        //     return back()->with('errorImagen', 'La imagen cargada no tiene el formato adecuado. (Formato aceptado: jpg');
        // }
        // $nombreImagen = $request->modelo . '.' . $request->imagen->getClientOriginalExtension();
        // $request->imagen->move(public_path('img'), $nombreImagen);

        //agregar los otros campos a medida se actualice la base de datos
        //esta guardando correctamente los datos

        return back()->with('exitoProductoAct', 'El nuevo producto ha sido actualizado en la Base de datos exitosamente.');
    }

    public function editarProducto($id)
    {
        $producto = Producto::findOrFail($id);
        $sobremodelos = Sobremodelo::get();

        return view('editarproducto', compact('producto', 'sobremodelos'));
    }

    public function buscarIndex()
    {
        $producto = Sobremodelo::query()->paginate(12);

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio')->distinct()->get();

        return view('buscar', compact('producto', 'imgModelos'));
    }
                    //scope es para poder utilizar el query mas adelante de forma mas rapida citando el nombre de la funcion
    public function scopeBuscarProducto(Request $request)
    {
        // dd($request->termino);
        $producto = Sobremodelo::where('titulo', 'like', "%{$request->termino}%")
            // ->orWhere('descripcion', 'like', "%{$request->termino}%")
            // ->orWhere('marca', 'like', "%{$request->termino}%")
            // ->orWhere('modelo', 'like', "%{$request->termino}%")
            ->paginate(50);

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio')->distinct()->get();

        return view('buscar', compact('producto', 'imgModelos'));
    }

    public function eliminarProducto($id)
    {   

        $producto = Producto::where('id', $id)->get();

        return view('eliminarproducto', compact('producto'));
    }

    public function confirmarEliminarProducto(Request $request)
    {   
        if(Carro::where('producto_id', $request->id)->get() !== null) {
            Carro::where('producto_id', $request->id)->delete();
        }

        Producto::where('id', $request->id)->delete();

        return redirect('/');
    }

}
