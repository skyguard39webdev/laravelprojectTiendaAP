<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Mail\SolicitudOrden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CarroController extends Controller
{   
    public function show()
    {
        // dd(Carro::where('user_id', $usuario->id)->get()[4]->producto->nombre); // esto anda, no lo puedo creer, se hace la busqueda con get(), devuelve una collecion para iterar, y se usa el nombre de la funcion y el atributo
        
        $usuario = Auth::user();

        $carro = Carro::where('user_id', $usuario->id)->get();

        return view('carro', compact('carro'));
    }


    public function carritoSaveProducto(Request $request)
    {   
        // dd($request->idProd);
        $usuario = Auth::user();
        $idUser = $usuario->id;
        if ($request->qty < 1) {
            return back()->with('error', 'Debe seleccionar un valor superior a 0 (cero).');
        }

        if ( DB::table('carros')->where('user_id', $idUser)->where('producto_id', $request->idProd )->count() > 0) {
            
            $carroActual = Carro::where('user_id', $idUser)->where('producto_id', $request->idProd )->first();
            $carroActual->qty = $carroActual->qty + $request->qty;
            $carroActual->save();

            return back()->with('exitoCarrito', 'Su pedido ha sido añadido a su carrito.'); // tiene que volver a la pagina que esta
        
        } else {
            
            $carro = Carro::create([
                'user_id' => $idUser,
                'producto_id' => $request->idProd,
                'qty' => $request->qty,
            ]);

            return back()->with('exitoCarrito', 'Su pedido ha sido añadido a su carrito.'); // tiene que volver a la pagina que esta
        }
        

        
    }

    public function resetAll()
    {
        $usuario = Auth::user();
        $idUser = $usuario->id;
        Carro::where('user_id', $idUser)->delete();

        return redirect('carro');
    }

    public function deleteAll(Request $request)
    {
        $usuario = Auth::user();
        $idUser = $usuario->id;

        $carroActual = Carro::where('user_id', $idUser)->where('producto_id', $request->idProd )->first();
        $carroActual->delete();
        
        return redirect('carro');
    }

    public function addOne(Request $request)
    {
        $usuario = Auth::user();
        $idUser = $usuario->id;

        $carroActual = Carro::where('user_id', $idUser)->where('producto_id', $request->idProd )->first();
        $carroActual->qty = $carroActual->qty + 1;
        $carroActual->save();

        return redirect('carro');

    }

    public function removeOne(Request $request)
    {
        $usuario = Auth::user();
        $idUser = $usuario->id;

        $carroActual = Carro::where('user_id', $idUser)->where('producto_id', $request->idProd )->first();
        $carroActual->qty = $carroActual->qty - 1;
        
        if($carroActual->qty == 0){

            $carroActual->delete();
            return redirect('carro');
        }
        
        $carroActual->save();

        return redirect('carro');
    }

    public function enviarPedido()
    {
        // dd(Carro::where('user_id', $usuario->id)->get()->all());
        $usuario = Auth::user();

        $carro = Carro::where('user_id', $usuario->id)->get()->all();

        $para_nombre = $usuario->name;
                                                    // $para_correo = 'pbandres2019@gmail.com';
        $para_correo = 'pbandres2019@gmail.com';    // cambiar a correo personal de andres pbandres2019@gmail.com


        if(Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4){
            
            Mail::to($para_correo)->send(new SolicitudOrden($carro));

            Carro::where('user_id', $usuario->id)->delete();

            return view('exito');
        } else {
            return view('error');
        }

        // hacer el borrado del carrito
    }

    public function exito()
    {
        if(url()->previous() == 'http://localhost:8000/carro'){
            return view('exito');
        } else {
            return view('error');
        }
    }

    public function error()
    {
        return view('error');
    }
}
