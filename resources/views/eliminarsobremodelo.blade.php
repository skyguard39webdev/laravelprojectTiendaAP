@extends('layouts.app')

@section('elimSobremodelo')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEliminarSobremodelo') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>Seleccione la tarjeta que desea eliminar</h4>
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
                <label for="sobremodelo" class="form-label">Tarjeta: </label>
                <select id="sobremodelo" class="form-select" name="sobremodelo_id" required>
                    <option selected>Seleccionar tarjeta</option>
                    @foreach($sobremodelos as $sm)
                    <option value="{{$sm->id}}"> {{$sm->titulo}} </option>
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