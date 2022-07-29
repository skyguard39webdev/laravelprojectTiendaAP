@extends('layouts.app')

@section('editarSubsubCategoria')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEditarSubsubcategoria') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>Seleccione la Sub-subcategoria que desea editar</h4>
                @if(session()->has('successUpdating'))
                    <div class="alert alert-success">
                        {{ session()->get('successUpdating') }}
                    </div>
                @endif
                <label for="subsubcategoria" class="form-label">Subsubcategoria: </label>
                <select id="subsubcategoria" class="form-select" onChange="update()" name="subsubcategoria_id" required>
                    <option selected>Seleccionar subsubcategoria</option>
                    @foreach($subsubcategorias as $ssc)
                    <option value="{{$ssc->id}}"> {{$ssc->nombre}} </option>
                    @endforeach
                </select>
                <label for="nuevotitulo" class="form-label">Nuevo nombre de subsubcategoria: </label>
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
            var select = document.getElementById("subsubcategoria");
            var nuevonombre = document.getElementById("nuevotitulo");
            var boton = document.getElementById("confirmar");
            var option = select.options[select.selectedIndex];
            
            var subsubcategorias = <?php echo json_encode($subsubcategorias); ?>; //esto sirve para traer una variable de php a javascript de forma eficaz

            if(subsubcategorias[select.selectedIndex-1] == null) {
                nuevonombre.value = "Seleccionar una subsubcategoria de la lista"
                nuevonombre.disabled = true;
                boton.disabled = true;
            } else{
                nuevonombre.disabled = false;
                boton.disabled = false;
                nuevonombre.value = subsubcategorias[select.selectedIndex-1].nombre;
            }
            
        }
    
        update();
    </script>

@endif
@endsection