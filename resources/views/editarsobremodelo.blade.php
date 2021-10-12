@extends('layouts.app')

@section('editarSobremodelo')
@if(Auth::user()->rol_id == 4)
    <form method="POST" action="{{ route('confirmarEditarSobremodelo') }}">
        @csrf
        <div class="container">
            <div class="row">
                <h4>Seleccione la tarjeta que desea editar</h4>
                @if(session()->has('successUpdating'))
                    <div class="alert alert-success">
                        {{ session()->get('successUpdating') }}
                    </div>
                @endif
                <label for="tarjeta" class="form-label">Tarjeta: </label>
                <select id="tarjeta" class="form-select" onChange="update()" name="sobremodelo_id" required>
                    <option selected>Seleccionar tarjeta</option>
                    @foreach($sobremodelos as $sm)
                    <option value="{{$sm->id}}"> {{$sm->titulo}} </option>
                    @endforeach
                </select>
                <label for="nuevotitulo" class="form-label">Nuevo nombre de tarjeta: </label>
                <input type="text" class="form-control" id="nuevotitulo" name="titulo" value="" required>
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
            var select = document.getElementById("tarjeta");
            var nuevonombre = document.getElementById("nuevotitulo");
            var boton = document.getElementById("confirmar");
            var option = select.options[select.selectedIndex];
            
            var sobremodelos = <?php echo json_encode($sobremodelos); ?>; //esto sirve para traer una variable de php a javascript de forma eficaz

            if(sobremodelos[select.selectedIndex-1] == null) {
                nuevonombre.value = "Seleccionar una tarjeta de la lista"
                nuevonombre.disabled = true;
                boton.disabled = true;
            } else{
                nuevonombre.disabled = false;
                boton.disabled = false;
                nuevonombre.value = sobremodelos[select.selectedIndex-1].titulo;
            }
            
        }
    
        update();
    </script>

@endif
@endsection