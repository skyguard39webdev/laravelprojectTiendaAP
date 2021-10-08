@extends('layouts.app')

@section('omsobremodelo')
@if (Route::has('login'))
    @isset (Auth::user()->rol_id)
        @if(Auth::user()->rol_id == 4)
            <form method="GET" action="{{ route('estadoSobremodeloSelect') }}">
                @csrf
                <div class="container mr-5 mb-5" id="top">
                    <ul class="nav nav-tabs justify-content-end">
                        <li class="nav-item align-middle pr-2">
                            <p class="align-middle pt-1">Seleccionar Estado:</p>
                        </li>
                        <li class="nav-item align-middle pr-2">
                            <select name="estado" class="form-select form-select-sm" aria-label="select">
                                <option selected value="0">Activos</option>
                                <option value="1">Ocultos</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <x-button class="">
                                {{ __('Buscar') }}
                            </x-button>
                        </li>
                    </ul>
                </div>
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
            <form method="POST" action="{{ route('estadoUpdate') }}">
                @csrf
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Seleccionar Estado</th>
                            </tr>
                        </thead>
                        @foreach ($listaSobremodelos as $lsm)
                            <tbody>
                                <tr>
                                    <td scope="row"> {{ $lsm->id }} </td>
                                    <td> {{ $lsm->titulo }} </td>
                                    @if ($lsm->oculto == 0)
                                    <td> Activo </td>
                                    @else
                                    <td> Oculto </td>
                                    @endif
                                    <td>
                                        <input type="hidden" name="id[]" value="{{ $lsm->id }}">
                                        <select name="estado[]" class="form-select form-select-sm" aria-label="select">
                                            <option selected value="{{ $lsm->oculto }}">Seleccionar Estado</option>
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
                    {{ $listaSobremodelos->links() }}
                </div>  
        @else
                <h4>Usted no tiene los permisos necesarios para visualizar esta pagina</h4>
        @endif
    @endisset
@endif
@endsection