@extends('layouts.app')

@section('omproductos')
@if (Route::has('login'))
    @isset (Auth::user()->rol_id)
        @if(Auth::user()->rol_id == 4)
            <div class="container-fluid" id="top">
                <div class="container">
                    <div class="">
                        <form method="GET" action="{{ route('estadoProductoSelect') }}">
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
                            {{-- @if(session()->has('errorBusquedaRol'))
                            <div class="alert alert-danger container">
                                {{ session()->get('errorBusquedaRol') }}
                            </div>
                            @endif --}}
                        </form>
                        <form method="GET" action="{{ route('buscarListaProductos') }}">
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
                            {{-- @if(session()->has('errorBusquedaRol'))
                            <div class="alert alert-danger container">
                                {{ session()->get('errorBusquedaRol') }}
                            </div>
                            @endif --}}
                            @if(session()->has('exitoUpdateEstado'))
                            <div class="alert alert-success container">
                                {{ session()->get('exitoUpdateEstado') }}
                            </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('estadoUpdate') }}">
                @csrf
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Modelo</th>
                                <th scope="col">Precio</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Seleccionar Estado</th>
                            </tr>
                        </thead>
                        @foreach ($listaProductos as $lp)
                            <tbody>
                                <tr>
                                    <td scope="row"> {{ $lp->id }} </td>
                                    <td> {{ $lp->titulo }} </td>
                                    <td> {{ $lp->modelo }} </td>
                                    <td> {{ $lp->precio }} </td>
                                    @if ($lp->oculto == 0)
                                    <td> Activo </td>
                                    @else
                                    <td> Oculto </td>
                                    @endif
                                    <td>
                                        <input type="hidden" name="id[]" value="{{ $lp->id }}">
                                        <select name="estado[]" class="form-select form-select-sm" aria-label="select">
                                            <option selected value="{{ $lp->oculto }}">Seleccionar Estado</option>
                                            <option value="0">Activo</option>
                                            <option value="1">Oculto</option>
                                        </select>
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


{{-- respaldo --}}

