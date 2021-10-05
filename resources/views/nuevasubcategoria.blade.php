@extends('layouts.app')

@section('nuevosubcatpriv')
@if(Auth::user()->rol_id == 4)
<div class="container col-8">
    <form method="POST" action="{{ route('ingresarSubCat') }}" class="row g-3" enctype="multipart/form-data">
        @csrf
        <h3>Ingresar nueva subcategoría</h3>
        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="col-lg-6 col-sm-12">
            <label for="nombreproducto" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreproducto" name="nombre" required autofocus>
        </div>
        <div class="col-lg-3 col-sm-12">
            <label for="categoriaproducto" class="form-label">Categoria Asociada</label>
            <select id="categoriaproducto" class="form-select" name="categoria" required>
                <option selected>Seleccionar categoria</option>
                @foreach($categorias as $c)
                <option value="{{$c->id}}"> {{$c->nombre}} </option>
                @endforeach
            </select>
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