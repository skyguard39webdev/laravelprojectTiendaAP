@extends('layouts.app')

@section('upriv')
@if (Route::has('login'))
    @isset (Auth::user()->rol_id)
        @if(Auth::user()->rol_id == 4)
            <form method="GET" action="{{ route('lista-usuariosRolSelect') }}">
                @csrf
                <div class="container mr-5 pr-5 mb-5">
                    <ul class="nav nav-tabs justify-content-end pr-5 mr-5">
                        <li class="nav-item align-middle pr-2">
                            <p class="align-middle">Seleccionar Rol:</p>
                        </li>
                        <li class="nav-item align-middle pr-2">
                            <select name="rol" class="form-select form-select-sm" aria-label="select">
                                <option selected value="0">Seleccionar Rol</option>
                                <option value="1">Confiado</option>
                                <option value="2">No Confiado</option>
                                <option value="3">Sin Rol</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <x-button class="ml-4">
                                {{ __('Buscar') }}
                            </x-button>
                        </li>
                    </ul>
                </div>
                @if(session()->has('errorBusquedaRol'))
                    <div class="alert alert-danger container">
                        {{ session()->get('errorBusquedaRol') }}
                    </div>
                @endif
                @if(session()->has('exitoUpdateRol'))
                    <div class="alert alert-success container">
                        {{ session()->get('exitoUpdateRol') }}
                    </div>
                @endif
            </form>
            <form method="POST" action="{{ route('updateRol') }}">
                @csrf
                <div class="container">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Nombre y apellido</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Rol Actual</th>
                                <th scope="col">Rol Asignado</th>
                            </tr>
                        </thead>
                        @foreach ($usuario as $u)
                            <tbody>
                                <tr>
                                    <td scope="row"> {{ $u->name }} </td>
                                    <td> {{ $u->email }} </td>
                                    <td> {{ $u->telefono }} </td>
                                    <td> {{ $u->rol->nombre }} </td>
                                    <td>
                                        <input type="hidden" name="id[]" value="{{ $u->id }}">
                                        <select name="rol[]" class="form-select form-select-sm" aria-label="select">
                                            <option selected value="{{ $u->rol_id }}">Seleccionar Rol</option>
                                            <option value="1">Confiado</option>
                                            <option value="2">No Confiado</option>
                                            <option value="3">Sin Rol</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>    
                        @endforeach
                    </table>
                </div>
                <div class="flex items-center container justify-end mt-1 mr-5 pr-1 mb-5 pb-5">
                    <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                        {{ __('Pagina principal') }}
                    </a>

                    <x-button class="ml-4">
                        {{ __('Confirmar Cambios') }}
                    </x-button>
                </div>
            </form>
                <div class="d-flex justify-content-center py-3">
                    {{ $usuario->links() }}
                </div>  
        @else
                <h4>Usted no tiene los permisos necesarios para visualizar esta pagina</h4>
        @endif
    @endisset
@endif
@endsection