@extends('layouts.app')

@section('carro')
    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-sm-12 col-md-12">
                @if (count($carro) > 0)
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Producto</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unitario</th>
                                <th scope="col">Subtotales</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                    @foreach ($carro as $c)
                        <tbody>
                            <tr>
                                <th scope="row">{{ $c->producto->titulo }}</th>
                                <td>{{ $c->producto->modelo }}</td>
                                <td>{{ $c->qty }}</td>
                                <td>{{ $c->producto->precio }}</td>
                                <td>
                                @php
                                    $precioTotalPorProducto = $c->producto->precio * $c->qty;
                                    echo $precioTotalPorProducto;    
                                @endphp
                                </td>
                                <td>
                                    {{-- agregar un solo item  --}}
                                    <form method="POST" action="{{ route('addone') }}">
                                        @csrf
                                        <button><i class="far fa-plus-square " title="Agregar 1 unidad"></i></button><input type="hidden" name="idProd" value="{{ $c->producto->id }}">
                                    </form>
                                    {{-- sacar un solo item  --}}
                                    <form method="POST" action="{{ route('removeone') }}">
                                        @csrf
                                        <button><i class="far fa-minus-square" title="Remover 1 unidad"></i></button><input type="hidden" name="idProd" value="{{ $c->producto->id }}">
                                    </form>
                                </td>
                                <td>
                                    {{-- borrado de fila de productos --}}
                                    <form method="POST" action="{{ route('deleteall') }}">
                                        @csrf
                                        <button><i class="fas fa-trash-alt" title="Remover estos productos"></i></button><input type="hidden" name="idProd" value="{{ $c->producto->id }}">
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    @endforeach
                    </table>
                    <div class="row">
                        <div class="flex items-center justify-end mt-1 mr-5 pr-1 mb-5 pb-5">
                            {{-- borrado de carro entero --}}
                            <form method="POST" action="{{ route('resetall') }}">
                                @csrf
                                <input type="hidden" name="idUser" value="{{ Auth::user()->id }}">
                                <x-button class="ml-4">
                                    {{ __('Eliminar Todo el Carro') }}
                                </x-button>
                            </form>                        
                        </div>
                    </div>
                @else
                    <div class="container">
                        <h5>Aun no tiene productos en su carrito.</h5>
                    </div>
                @endif
            </div>
            <div class="col-lg-3 col-sm-12 col-md-12">
                <div class="container pt-2">
                    <h5 class="ml-3"><strong> Totales </strong></h5>
                    <p class="ml-3"> <strong> IVA: </strong> USD
                        @php
                            $precioTotal = 0;
                            foreach ($carro as $c)
                                $precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;
                            echo $precioTotal*0.22
                        @endphp
                    </p>
                    <p class="ml-3"><strong> SubTotal: </strong> USD
                    @php
                        $precioTotal = 0;
                        foreach ($carro as $c)
                            $precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;
                        echo $precioTotal
                    @endphp
                    </p>
                    <p class="ml-3"><strong> Total A Pagar: </strong> USD
                        @php
                            $precioTotal = 0;
                            foreach ($carro as $c)
                                $precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;
                            echo $precioTotal*1.22
                        @endphp
                    </p>
                    <hr>
                    <br>
                    @if (count($carro) > 0)
                        <div class="flex items-center justify-end mt-1 mr-5 pr-1 mb-5 pb-5">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                                {{ __('Seguir comprando') }}
                            </a>
                            <a href="/enviarpedido">
                                <x-button class="ml-4">
                                    {{ __('Realizar Pedido') }}
                                </x-button>
                            </a>
                        </div>
                    @else
                        <div></div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection