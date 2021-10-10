@extends('layouts.app')

@section('editarpreciosproductos')
@if (Route::has('login'))
    @isset (Auth::user()->rol_id)
        @if(Auth::user()->rol_id == 4)
            <div class="container-fluid" id="top">
                <div class="container">
                    <div class="">
                        <form method="GET" action="{{ route('estadoPrecioSelect') }}">
                            @csrf
                            <ul class="nav nav-tabs pb-2">
                                <li class="nav-item align-middle pr-2 mt-1">
                                    <p class="align-middle pt-1">Seleccionar Estado:</p>
                                </li>
                                <li class="nav-item align-middle pr-2 mt-1">
                                    <select name="estado" class="form-select form-select-sm" aria-label="select">
                                        <option selected value="0">Activos</option>
                                        <option value="1">Ocultos</option>
                                    </select>
                                </li>
                                <li class="nav-item mt-1">
                                    <x-button class="">
                                        {{ __('Buscar') }}
                                    </x-button>
                                </li>
                            </ul>
                        </form>
                        <form method="GET" action="{{ route('buscarListaProductosPrecios') }}">
                            @csrf
                            <ul class="nav nav-tabs py-2">
                                <li class="nav-item align-middle pr-2 mt-1">
                                    <p class="align-middle pt-1">Buscar por titulo o modelo:</p>
                                </li>
                                <li class="nav-item align-middle pr-2 mt-1">
                                    <input type="text" class="form-control col-sm-12 col-md-6 col-lg-6" name="termino" placeholder="Escriba aqui" style="line-height: 0.5em">
                                </li>
                                <li class="nav-item mt-1">
                                    <x-button class="">
                                        {{ __('Buscar') }}
                                    </x-button>
                                </li>
                            </ul>
                            @if(session()->has('exitoUpdatePrecio'))
                            <div class="alert alert-success container">
                                {{ session()->get('exitoUpdatePrecio') }}
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('precioUpdate') }}">
                @csrf
                <div class="container">
                    <table class="table table-striped table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Nuevo Precio</th>
                            </tr>
                        </thead>
                        @foreach ($listaProductos as $lp)
                            <tbody>
                                <tr>
                                    <th scope="row"> {{ $lp->id }} </td>
                                    <td> {{ $lp->titulo }} </td>
                                    <td> {{ $lp->modelo }} </td>
                                    @if ($lp->oculto == 0)
                                    <td class="text-success"><strong> Activo </strong></td>
                                    @else
                                    <td class="text-danger"><strong> Oculto </strong></td>
                                    @endif
                                    <td> {{ $lp->precio }}</td>
                                    <td>
                                        <input type="hidden" name="id[]" value="{{ $lp->id }}">
                                        <input type="numeric" class="form-control" id="precioproducto" name="precio[]" value="{{ $lp->precio}}" style="line-height: 0.5em"required>
                                    </td>
                                </tr>
                            </tbody>    
                        @endforeach
                    </table>
                </div>
                <div class="flex items-center container justify-end mt-1 mr-5 mb-5">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="#top">
                        {{ __('Ir al Principio') }}
                    </a>

                    <a class="underline text-sm text-gray-600 hover:text-gray-900 ml-4" href="/">
                        {{ __('Pagina principal') }}
                    </a>

                    <x-button class="ml-4">
                        {{ __('Confirmar Cambios') }}
                    </x-button>
                </div>
            </form>
                <div class="d-flex justify-content-center py-3">
                    {{ $listaProductos->links() }}
                </div>  
        @else
                <h4>Usted no tiene los permisos necesarios para visualizar esta pagina</h4>
        @endif
    @endisset
@endif
@endsection