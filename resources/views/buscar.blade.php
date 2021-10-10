@extends('layouts.app')

@section('buscarprod')
    <div class="container-fluid">
        <form method="GET" action="{{ route('buscarProducto') }}" class="row g-3" enctype="multipart/form-data">
            <div class="container d-flex justify-content-center col-8 pb-4">
                <input type="text" class="form-control col-sm-12 col-md-6 col-lg-6" name="termino" autofocus placeholder="Escriba aqui">
                <x-button class="">
                    {{ __('Buscar') }}
                </x-button>
            </div>
        </form>
        <div class="row">
            @foreach ($producto as $p)
                @if($p->oculto != 1)
                    <div class="col-sm-6 col-md-4 col-lg-3 pb-3 pt-2">
                        <div class="card cardhover position-relative top-50 start-50 translate-middle text-center" style="width: 210px; height: 470px;">
                            @if (!isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id]))
                            <a href="/detalle/{{ $p->id }}" class="link-dark disabledifempty">
                            @else
                            <a href="/detalle/{{ $p->id }}" class="link-dark">
                            @endif
                                @php
                                    $modelo = '';
                                    foreach ($imgModelos as $imgm)
                                        if($p->titulo == $imgm->sobremodelo->titulo) {
                                            $modelo = $imgm->modelo;
                                        } else {
                                            $modelo = $modelo;
                                        }
                                    $url = "img" . "/" . $modelo . ".jpg";
                                    $img = "<img src='" . asset($url) . "' class='card-img-top img-fluid' alt='" . $p->modelo . "'>";
                                    echo $img;
                                @endphp
                                <div class="card-body">
                                    <h5 class="card-title">{{ $p->titulo }}</h5>
                                    @if (Route::has('login'))
                                        @auth
                                            <p class="text-decoration-none">
                                                @if (Route::has('login'))
                                                    @isset (Auth::user()->rol_id)
                                                        @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4 && isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id]))
                                                            @if(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id] > 1)
                                                                @php
                                                                    $minimo = 1000000000000;
                                                                    foreach ($imgModelos as $imgm)
                                                                        if($p->titulo == $imgm->sobremodelo->titulo) {
                                                                            if($minimo > $imgm->precio && $imgm->precio != 0  && $imgm->oculto == 0) {
                                                                                $minimo = $imgm->precio;
                                                                            }else {
                                                                                $minimo = $minimo;
                                                                            }
                                                                        }
                                                                    $min = '';
                                                                    if ($minimo == 1000000000000){
                                                                        $min = "<strong class='text-danger'>AGOTADO</strong>";
                                                                    } else{
                                                                        $min = "<strong class='text-danger'>Varios modelos desde USD " . $minimo . "</strong>";
                                                                    }
                                                                    echo $min;
                                                                @endphp
                                                            @else
                                                                @php
                                                                    $minimo = 1000000000000;
                                                                    foreach ($imgModelos as $imgm)
                                                                        if($p->titulo == $imgm->sobremodelo->titulo ) {
                                                                            if($minimo > $imgm->precio && $imgm->precio != 0 && $imgm->oculto == 0) {
                                                                                $minimo = $imgm->precio;
                                                                            }else {
                                                                                $minimo = $minimo;
                                                                            }
                                                                        }
                                                                    $min = "<strong class='text-danger'>USD " . $minimo . "</strong>";
                                                                    echo $min;
                                                                @endphp
                                                            @endif
                                                        @else
                                                            Agregar productos - Enlace deshabilitado temporalmente
                                                        @endif
                                                    @endisset
                                                @endif
                                            </p>
                                        @else
                                            @if(isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id]) && array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id] > 1)
                                                <p class="text-decoration-none">
                                                    Varios modelos
                                                </p>
                                            {{-- @elseif (array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id] == 1)
                                                <p class="text-decoration-none">
                                                    Ver detalle
                                                </p> --}}
                                            @else 
                                                <p class="text-decoration-none"> Ver detalle</p>
                                            @endif
                                        @endauth
                                    @endif
                                </div>                        
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center py-3">
        {{ $producto->links() }}
    </div>
@endsection