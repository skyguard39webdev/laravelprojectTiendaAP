@extends('layouts.app')

@section('destacar')
@if (Route::has('login'))
    @isset (Auth::user()->rol_id)
        @if(Auth::user()->rol_id == 4)
            <form method="GET" action="{{ route('destaqueSelect') }}">
                @csrf
                <div class="container mr-5 mb-5" id="top">
                    <ul class="nav nav-tabs justify-content-end">
                        <li class="nav-item align-middle pr-2">
                            <p class="align-middle pt-1">Seleccionar Estado:</p>
                        </li>
                        <li class="nav-item align-middle pr-2">
                            <select name="estado" class="form-select form-select-sm" aria-label="select">
                                <option selected value="0">No Destacado</option>
                                <option value="1">Destacado</option>
                            </select>
                        </li>
                        <li class="nav-item">
                            <x-button class="">                      
                                {{ __('Buscar') }}
                            </x-button>
                        </li>
                    </ul>
                </div>
                @if(session()->has('exitoUpdateEstado'))
                    <div class="alert alert-success container">
                        {{ session()->get('exitoUpdateEstado') }}
                    </div>
                @endif
            </form>
            <form method="POST" action="{{ route('estadoDestaque') }}">
                @csrf
                <div class="container">
                    <table class="table table-striped table-bordered table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Titulo</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Destacado</th>
                            </tr>
                        </thead>
                        @foreach ($listaSobremodelos as $lsm)
                            <tbody>
                                <tr>
                                    <th scope="row"> {{ $lsm->id }} </td>
                                    {{-- <td scope="row"> <img src="{{ asset('img/'.$lsm->modelo.'.jpg') }}" alt="mini" class="" width="48"></td>
                                    <td>
                                        <a class="text-white" style="text-decoration: none;" href="/detalle/{{ $lsm->id }}/{{ $lsm->sobremodelo_id }}">{{ $lsm->titulo }}</a>
                                        <a href="/editarProducto/{{$lsm->id}}" class="underline text-sm text-info ml-2">Editar</a>
                                        <a href="/eliminarProducto/{{$lsm->id}}" class="underline text-sm text-info ml-2">Eliminar</a>
                                    </td> --}}
                                    <td> {{ $lsm->titulo }} </td>
                                    @if ($lsm->destacado == 0)
                                    <td class="text-danger"><strong> No Destacado </strong></td>
                                    @else
                                    <td class="text-success"><strong> Destacado </strong></td>
                                    @endif
                                    <td>
                                        <input type="hidden" name="id[]" value="{{ $lsm->id }}">
                                        <select name="destacado[]" class="form-select form-select-sm" aria-label="select">
                                            <option selected value="{{ $lsm->destacado }}">Seleccionar Estado</option>
                                            <option value="0">No Destacado</option>
                                            <option value="1">Destacado</option>
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