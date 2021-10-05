@extends('layouts.app')

@section('elimProd')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEliminarProducto') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>¿Está seguro que desea eliminar {{$producto[0]->titulo}} de la base de datos?</h4>
                <input type="hidden" class="form-control" id="idproductoborrar" name="id" value="{{ $producto[0]->id}}" required>
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