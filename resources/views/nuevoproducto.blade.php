@extends('layouts.app')

@section('nuevoprodpriv')
<div class="container col-8">
    @if(Auth::user()->rol_id == 4)
        <form method="POST" action="{{ route('ingresarProducto') }}" class="row g-3" enctype="multipart/form-data">
            @csrf
            <h3>Ingresar nuevo producto</h3>
            @if(session()->has('exitoProducto'))
                <div class="alert alert-success">
                    {{ session()->get('exitoProducto') }}
                </div>
            @endif
            @if(session()->has('nullPrecio'))
                <div class="alert alert-danger">
                    {{ session()->get('nullPrecio') }}
                </div>
            @endif
            @if(session()->has('nanPrecio'))
                <div class="alert alert-danger">
                    {{ session()->get('nanPrecio') }}
                </div>
            @endif
            @if(session()->has('nullSobremodelo'))
                <div class="alert alert-danger">
                    {{ session()->get('nullSobremodelo') }}
                </div>
            @endif
            <div class="col-lg-6 col-sm-12">
                <label for="nombreproducto" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="nombreproducto" name="titulo" required autofocus>
            </div>
            <div class="col-lg-3 col-sm-12">
                <label for="marcaproducto" class="form-label">Marca</label>
                <input type="text" class="form-control" id="marcaproducto" name="marca" required>
            </div>
            <div class="col-lg-3 col-sm-12">
                <label for="modeloproducto" class="form-label">Modelo</label>
                <input type="text" class="form-control" id="modeloproducto" name="modelo" required>
            </div>
            {{-- <div class="col-lg-6 col-sm-12">
                <label for="tituloproducto" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="tituloproducto" name="titulo" required>
            </div> --}}
            <div class="col-lg-2 col-sm-12">
                <label for="precioproducto" class="form-label">Precio</label>
                <input type="numeric" class="form-control" id="precioproducto" name="precio" required>
            </div>
            <div class="col-lg-2 col-sm-12">
                <label for="imagenproducto" class="form-label">Imagen</label>
                <input type="file" class="form-control" id="imagenproducto" name="imagen" required>
            </div>
            <div class="col-lg-2 col-sm-12">
                <label for="categoriaproducto" class="form-label">Subcategoria</label>
                <select id="categoriaproducto" class="form-select" name="categoria" required>
                    <option selected value="">Seleccionar categoria</option>
                    @foreach($subcategorias as $sc)
                    <option value="{{$sc->id}}">{{$sc->nombre}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-6 col-sm-12">
                <label for="categoriaproducto" class="form-label">Seleccionar sobremodelo <a href="/nuevo-sobremodelo" class="link-dark" id="1234">(O ingresar uno nuevo)</a></label>
                <select id="categoriaproducto" class="form-select" name="sobremodelo" required>
                    <option selected value="">Seleccionar sobre-modelo</option>
                    @foreach($sobremodelos as $sm)
                    <option value="{{$sm->id}}">{{$sm->titulo}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-lg-1 col-sm-12">
                <label for="pesoproducto" class="form-label">Peso</label>
                <input type="numeric" class="form-control" id="pesoproducto" name="peso" >
            </div>
            <div class="col-lg-1 col-sm-12">
                <label for="tramosproducto" class="form-label">Tramos</label>
                <input type="numeric" class="form-control" id="tramosproducto" name="tramos" >
            </div>
            <div class="col-lg-1 col-sm-12">
                <label for="tmtsproducto" class="form-label">Tms. mts.</label>
                <input type="numeric" class="form-control" id="tmtsproducto" name="tmts" >
            </div>
            <div class="col-lg-1 col-sm-12">
                <label for="pcsproducto" class="form-label">PCs</label>
                <input type="numeric" class="form-control" id="pcsproducto" name="pcs" >
            </div>
            <div class="col-lg-12 col-sm-12">
                <label for="descproducto" class="form-label">Descripcion</label>
                <textarea class="form-control" rows="1" id="descproducto" name="descripcion" ></textarea>
            </div>
            <div class="flex items-center justify-end mt-1 mr-5 pr-1 pt-3 mb-5 pb-5">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                    {{ __('Administración principal') }}
                </a>
    
                <x-button class="ml-4">
                    {{ __('Confirmar') }}
                </x-button>
            </div>
    
    
    
        </form>
    @endif
</div>
@endsection