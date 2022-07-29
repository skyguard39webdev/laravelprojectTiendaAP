@extends('layouts.app')

@section('elimsubsubcat')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEliminarSubsubcategoria') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>Seleccione la subsubcategoria que desea eliminar</h4>
                @if(session()->has('errorDeleating'))
                    <div class="alert alert-danger">
                        {{ session()->get('errorDeleating') }}
                    </div>
                @endif
                @if(session()->has('successDeleating'))
                    <div class="alert alert-success">
                        {{ session()->get('successDeleating') }}
                    </div>
                @endif
                <label for="sobremodelo" class="form-label">Subsubcategoria: </label>
                <select id="sobremodelo" class="form-select" name="subsubcategoria" required>
                    <option selected>Seleccionar subsubcategoria</option>
                    @foreach($subsubcategorias as $ssc)
                    <option value="{{$ssc->id}}"> {{$ssc->nombre}} </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-center justify-start ml-3 mt-1 pt-3 mb-5 pb-5 col-lg-3 col-sm-12">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                    {{ __('Cancelar') }}
                </a>
                <x-button class="ml-4">
                    {{ __('Continuar') }}
                </x-button>
            </div>
        </div>
    </form>
@endif
@endsection