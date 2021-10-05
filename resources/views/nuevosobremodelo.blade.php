@extends('layouts.app')

@section('nuevosobremod')
@if(Auth::user()->rol_id == 4)
<div class="container col-8">
    <form method="POST" action="{{ route('ingresarSobremodelo') }}" class="row g-3" enctype="multipart/form-data">
        @csrf
        <h3>Ingresar nuevo Sobremodelo</h3>
        @if(session()->has('exitoSobremodelo'))
            <div class="alert alert-success">
                {{ session()->get('exitoSobremodelo') }}
            </div>
        @endif
        <div class="col-lg-6 col-sm-12">
            <label for="sobremodelo" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="sobremodelo" name="titulo" required autofocus>
        </div>
        <div class="flex items-center justify-start mt-1 mr-5 pr-1 pt-3 mb-5 pb-5">
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                {{ __('Administración principal') }}
            </a>

            <x-button class="ml-4">
                {{ __('Confirmar') }}
            </x-button>
        </div>
    </form>
</div>
@endif
@endsection