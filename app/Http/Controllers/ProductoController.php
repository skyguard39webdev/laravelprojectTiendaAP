<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Subcategoria;
use App\Models\Producto;
use App\Models\Carro;
use App\Models\Sobremodelo;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function cat($cat)
    {
        // ESTO AL PARECER RECOJE LOS PRODUCTOS DE LA CATEGORIA CORRECTA SIN REPETIRSE
        // WOOOOOOOOOOOOOOOOOOOOOOOW HOW THE FUCK IT IS WORKING, I DON'T KNOW, DON'T ASK ME
        $producto = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('productos.subcategoria_id', $cat)
            ->where('productos.oculto', 0)
            ->where('sobremodelos.oculto', 0)
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->paginate(12);
            
        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')
            ->where('subcategoria_id', $cat)
            ->where('oculto', 0)
            ->distinct()
            ->get();

        return view('productos.cat', compact('producto', 'imgModelos'));
    }

    public function idProd($id)  // Detalle1
    {
        $producto = Producto::where('sobremodelo_id', $id)->where('oculto', 0)->get();
        
        if(isset($producto[0]->titulo)) {
            $relacionado = explode(' ', $producto[0]->titulo, -1);
        }

        if(empty($relacionado)) {
            $recomendados = Sobremodelo::latest()->limit(4)->get();
        }else {
            $recomendados = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
                ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
                ->where('sobremodelos.titulo', 'like', "%{$relacionado[0]}%")
                ->where('productos.oculto', 0)
                ->where('sobremodelos.oculto', 0)
                ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
                ->limit(4)
                ->get();
        }

        $sobremodelos = Sobremodelo::where('oculto', 0)->get();

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->where('oculto', 0)->distinct()->get();

        return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'sobremodelos'));
    }

    public function detalleextra($producto_id, $sobremodelo_id) // Detalle2
    {
        $producto = Producto::where('sobremodelo_id', $sobremodelo_id)->get();

        $main_producto = Producto::where('id', $producto_id)->get();

        if(isset($producto[0]->titulo)) {
            $relacionado = explode(' ', $producto[0]->titulo, -1);
        }

        if(empty($relacionado)) {
            $recomendados = Sobremodelo::latest()->where('oculto', 0)->limit(4)->get();
        }else {
            $recomendados = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
                ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
                ->where('sobremodelos.titulo', 'like', "%{$relacionado[0]}%")
                ->where('productos.oculto', 0)
                ->where('sobremodelos.oculto', 0)
                ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
                ->limit(4)
                ->get();
        }

        $sobremodelos = Sobremodelo::where('oculto', 0)->get();

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->where('oculto', 0)->distinct()->get();

        // dd($main_producto->all()[0]->oculto);
        if (Auth::user() != null) {
            $usuarioLoggeado = Auth::user();
            if ($usuarioLoggeado->rol_id == 4 && $main_producto->all()[0]->oculto == 1) {
                session()->flash('advertenciaOculto', 'Está visualizando esta pagina como administrador. El producto que está visualizando está oculto');
                return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'main_producto', 'sobremodelos'));
            } else if ($usuarioLoggeado->rol_id != 4 && $main_producto->all()[0]->oculto == 1) {
                App::abort(404, 'Error. Pagina no encontrada!');
            } else if ($usuarioLoggeado->rol_id != 4) {
                return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'main_producto', 'sobremodelos'));
            }else {
                return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'main_producto', 'sobremodelos'));
            }
        } else if ($main_producto->all()[0]->oculto == 1){
            abort(404, 'Error. Pagina no encontrada.');
        } else {
            return view('detalle', compact('producto', 'recomendados', 'imgModelos', 'main_producto', 'sobremodelos'));
        }
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
        $producto->oculto = 0;
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
        $producto = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('productos.oculto', 0)
            ->where('sobremodelos.oculto', 0)
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->paginate(12);

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->where('oculto', 0)->distinct()->get();

        return view('buscar', compact('producto', 'imgModelos'));
    }
                    //scope es para poder utilizar el query mas adelante de forma mas rapida citando el nombre de la funcion
    public function scopeBuscarProducto(Request $request)
    {
        $producto = Sobremodelo::select('sobremodelos.id','sobremodelos.titulo', 'sobremodelos.oculto')
            ->join('productos', 'sobremodelos.id', '=', 'productos.sobremodelo_id')
            ->where('sobremodelos.titulo', 'like', "%{$request->termino}%")
            ->where('productos.oculto', 0)
            ->where('sobremodelos.oculto', 0)
            ->groupBy('sobremodelos.titulo','sobremodelos.titulo')
            ->paginate(12);

        $imgModelos = Producto::select('modelo', 'sobremodelo_id', 'precio', 'oculto')->where('oculto', 0)->distinct()->get();

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

    public function estadoProductoSelect(Request $request)
    {
        $listaProductos = Producto::query()->where('oculto', $request->estado)->paginate(1000); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('ocultarmostrar-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function estadoUpdate(Request $request)
    {
        $checksave = FALSE;
        $index = 0;
        foreach ($request->all()['id'] as $rid) {
            $producto = Producto::findOrFail($rid);
            $producto->oculto = $request->all()['estado'][$index];
            $checksave = $producto->save();
            $index++;
            
        }
        if ($checksave) {
            return redirect('/lista-productos')->with('exitoUpdateEstado', 'Los estados han sido actualizados con exito.');
        } else {
            App::abort(500, 'Error');
        }
    }


    public function estadoUpdateProducto(Request $request)
    {
        $checksave = FALSE;
        $index = 0;
        foreach ($request->all()['id'] as $rid) {
            $producto = Producto::findOrFail($rid);
            $producto->oculto = $request->all()['estado'][$index];
            $checksave = $producto->save();
            $index++;
            
        }
        if ($checksave) {
            return redirect('/lista-productos')->with('exitoUpdateEstado', 'Los estados han sido actualizados con exito.');
        } else {
            App::abort(500, 'Error');
        }
    }

    public function showListaProductos()
    {
        $listaProductos = Producto::query()->paginate(1000); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('ocultarmostrar-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function buscarListaProductos(Request $request)
    {
        $listaProductos = Producto::where('titulo', 'like', "%{$request->termino}%")
            // ->orWhere('descripcion', 'like', "%{$request->termino}%")
            // ->orWhere('marca', 'like', "%{$request->termino}%")
            ->orWhere('modelo', 'like', "%{$request->termino}%")
            ->paginate(1000);
            
        $usuarioLoggeado = Auth::user();
        
        if ( $usuarioLoggeado->rol_id == 4) {
            return view('ocultarmostrar-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function showListaProductosPrecio()
    {
        $listaProductos = Producto::query()->paginate(1000); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('editarprecios-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function buscarListaProductosPrecios(Request $request)
    {
        $listaProductos = Producto::where('titulo', 'like', "%{$request->termino}%")
            // ->orWhere('descripcion', 'like', "%{$request->termino}%")
            // ->orWhere('marca', 'like', "%{$request->termino}%")
            ->orWhere('modelo', 'like', "%{$request->termino}%")
            ->paginate(1000);
            
        $usuarioLoggeado = Auth::user();
        
        if ( $usuarioLoggeado->rol_id == 4) {
            return view('editarprecios-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function precioUpdate(Request $request)
    {
        $checksave = FALSE;
        $index = 0;
        foreach ($request->all()['id'] as $rid) {
            $producto = Producto::findOrFail($rid);
            if(ctype_alpha($request->all()['precio'][$index])) {
                $producto->precio = $producto->precio;
            // } elseif (ctype_alnum($request->all()['precio'][$index])) {
            //     //agregar custom messages for with
            //     $producto->precio = $producto->precio;
            } else {
                $producto->precio = $request->all()['precio'][$index];
            }
            $checksave = $producto->save();
            $index++;
            
        }
        if ($checksave) {
            return redirect('/lista-productos-precio')->with('exitoUpdatePrecio', 'Los precios han sido actualizados con exito.');
        } else {
            App::abort(500, 'Error');
        }
    }

    public function estadoPrecioSelect(Request $request)
    {
        $listaProductos = Producto::query()->where('oculto', $request->estado)->paginate(1000); // puede ser que sean de hasta 100 filas

        $usuarioLoggeado = Auth::user();

        if ( $usuarioLoggeado->rol_id == 4) {
            return view('editarprecios-productos', compact('listaProductos'));
        }
        else {
            return redirect('/');
        }
    }

    public function moverProductoTarjeta(Request $request)
    {
        if ($request->accion == 0) {           // crear tarjeta y mover
            $sobremodelo = new Sobremodelo;
            $unique = Sobremodelo::where('titulo', $request->titulo)->get();
            if (isset($unique->all()[0]->titulo)){
                if (strtolower($unique->all()[0]->titulo) == strtolower($request->titulo)) {
                    return back()->with('errorCrear', 'El titulo de tarjeta ya existe.');
                }
            }
            if ($request->titulo == null) {
                return back()->with('errorCrear', 'El campo de titulo de tarjeta no puede estar vacío.');
            }
            $sobremodelo->titulo = $request->titulo;
            $sobremodelo->oculto = 0;
            $checksave = $sobremodelo->save();

            $producto = Producto::findOrFail($request->id);
            $producto->sobremodelo_id = $sobremodelo->id;
            $producto->save();
            
            if (!$checksave){
                App::abort(500, 'Error');
            }else {
                return redirect('/detalle/'.$producto->id.'/'.$sobremodelo->id)->with('exitoCrear', 'Se ha creado la nueva tarjeta y movido el producto con exito.');
            }

        }else if ($request->accion == 1) {    // mover a otra tarjeta
            $producto = Producto::findOrFail($request->id);
            $producto->sobremodelo_id = $request->sobremodelo_id;
            $checksave = $producto->save();
            
            if (!$checksave){
                App::abort(500, 'Error');
            }else {
                return redirect('/detalle/'.$producto->id.'/'.$producto->sobremodelo_id)->with('exitoMover', 'Se ha movido el producto a la tarjeta seleccionada con exito.');
            }
        }
    }

}
