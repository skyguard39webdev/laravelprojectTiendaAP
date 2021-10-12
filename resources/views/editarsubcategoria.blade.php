@extends('layouts.app')

@section('editarCategoria')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEditarSubcategoria') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>Seleccione la categoria que desea editar</h4>
                @if(session()->has('successUpdating'))
                    <div class="alert alert-success">
                        {{ session()->get('successUpdating') }}
                    </div>
                @endif
                <label for="subcategoria" class="form-label">Subcategoria: </label>
                <select id="subcategoria" class="form-select" onChange="update()" name="subcategoria_id" required>
                    <option selected>Seleccionar subcategoria</option>
                    @foreach($subcategorias as $sc)
                    <option value="{{$sc->id}}"> {{$sc->nombre}} </option>
                    @endforeach
                </select>
                <label for="nuevotitulo" class="form-label">Nuevo nombre de subcategoria: </label>
                <input type="text" class="form-control" id="nuevotitulo" name="nombre" value="" required>
            </div>
            <div class="flex items-center justify-start ml-3 mt-1 pt-3 mb-5 pb-5 col-lg-3 col-sm-12">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                    {{ __('Cancelar') }}
                </a>
                <x-button class="ml-4" id="confirmar">
                    {{ __('Continuar') }}
                </x-button>
            </div>
        </div>
    </form>
    <script type="text/javascript">
        function update() {
            var select = document.getElementById("subcategoria");
            var nuevonombre = document.getElementById("nuevotitulo");
            var boton = document.getElementById("confirmar");
            var option = select.options[select.selectedIndex];
            
            var subcategorias = <?php echo json_encode($subcategorias); ?>; //esto sirve para traer una variable de php a javascript de forma eficaz

            if(subcategorias[select.selectedIndex-1] == null) {
                nuevonombre.value = "Seleccionar una subcategoria de la lista"
                nuevonombre.disabled = true;
                boton.disabled = true;
            } else{
                nuevonombre.disabled = false;
                boton.disabled = false;
                nuevonombre.value = subcategorias[select.selectedIndex-1].nombre;
            }
            
        }
    
        update();
    </script>

@endif
@endsection