@extends('layouts.app')

@section('prod')
    <div class="container-fluid">
    @if(!isset(Request::all()['page']) > 0)
        <div class="row">
            <div class="d-flex justify-content-center col-xs-12">
                <div class="col-sm-12 d-md-block">
                    <span class="">
                        <img src="{{ asset('img/productos_destacados_1.jpg') }}" alt="Banner" class="mt-2"> 
                    </span>
                </div>
            </div>
            {{-- random comment --}}
            @foreach ($agregados as $a)
                <div class="col-sm-6 col-md-4 col-lg-3 pb-3 pt-2">
                    @if (!isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$a->id]))
                    <a href="/detalle/{{ $a->id }}" class="link-dark disabledifempty">
                    @else
                    <a href="/detalle/{{ $a->id }}" class="link-dark">
                    @endif
                        <div class="card cardhover position-relative top-50 start-50 translate-middle text-center" style="width: 210px; height: 420px;">
                            @php
                                $modelo = '';
                                foreach ($imgModelos as $imgm)
                                    if($a->titulo == $imgm->sobremodelo->titulo) {
                                        $modelo = $imgm->modelo;
                                    } else {
                                        $modelo = $modelo;
                                    }
                                $url = "img" . "/" . $modelo . ".jpg";
                                $img = "<img src='" . asset($url) . "' class='card-img-top img-fluid' alt='" . $a->modelo . "'>";
                                echo $img;
                            @endphp
                            <div class="card-body">
                                <h5 class="card-title">{{ $a->titulo }}</h5>
                                @if (Route::has('login'))
                                    @auth
                                        <p class="text-decoration-none">
                                            @if (Route::has('login'))
                                                @isset (Auth::user()->rol_id)
                                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4 && isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$a->id]))
                                                        @if(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$a->id] > 1)
                                                            @php
                                                                $minimo = 1000000000000;
                                                                foreach ($imgModelos as $imgm)
                                                                    if($a->titulo == $imgm->sobremodelo->titulo) {
                                                                        if($minimo > $imgm->precio && $imgm->precio != 0) {
                                                                            $minimo = $imgm->precio;
                                                                        }else {
                                                                            $minimo = $minimo;
                                                                        }
                                                                    }
                                                                $min = "<strong class='text-danger'>Varios modelos desde USD " . $minimo . "</strong>";
                                                                echo $min;
                                                            @endphp
                                                        @else
                                                            <strong class="text-danger">USD {{ $a->producto->precio }}</strong></h4>
                                                        @endif
                                                    @else
                                                        Agregar productos
                                                    @endif
                                                @endisset
                                            @endif
                                        </p>
                                    @else
                                        @if(isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$a->id]) && array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$a->id] > 1)
                                            <p class="text-decoration-none">
                                                Varios modelos
                                            </p>
                                        @else
                                            <p class="text-decoration-none">
                                                Ver detalle
                                            </p>
                                        @endif
                                    @endauth
                                @endif
                            </div>                        
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="d-flex justify-content-center col-xs-12">
                <div class="col-sm-12 d-md-block">
                    <span class="">
                        <img src="{{ asset('img/productos_actualizados.jpg') }}" alt="Banner" class="mt-2"> 
                    </span>
                </div>
            </div>
            @foreach ($actualizados as $act)
                <div class="col-sm-6 col-md-4 col-lg-3 pb-3 pt-2">
                    @if (!isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$act->id]))
                    <a href="/detalle/{{ $act->id }}" class="link-dark disabledifempty">
                    @else
                    <a href="/detalle/{{ $act->id }}" class="link-dark">
                    @endif
                        <div class="card cardhover position-relative top-50 start-50 translate-middle text-center" style="width: 210px; height: 420px;">
                            @php
                                $modelo = '';
                                foreach ($imgModelos as $imgm)
                                    if($act->titulo == $imgm->sobremodelo->titulo) {
                                        $modelo = $imgm->modelo;
                                    } else {
                                        $modelo = $modelo;
                                    }
                                $url = "img" . "/" . $modelo . ".jpg";
                                $img = "<img src='" . asset($url) . "' class='card-img-top img-fluid' alt='" . $act->modelo . "'>";
                                echo $img;
                            @endphp
                            <div class="card-body">
                                <h5 class="card-title">{{ $act->titulo }}</h5>
                                @if (Route::has('login'))
                                    @auth
                                        <p class="text-decoration-none">
                                            @if (Route::has('login'))
                                                @isset (Auth::user()->rol_id)
                                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4 && isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$act->id]))
                                                        @if(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$act->id] > 1)
                                                            @php
                                                                $minimo = 1000000000000;
                                                                foreach ($imgModelos as $imgm)
                                                                    if($act->titulo == $imgm->sobremodelo->titulo) {
                                                                        if($minimo > $imgm->precio && $imgm->precio != 0) {
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
                                                            <strong class="text-danger">USD {{ $act->producto->precio }}</strong></h4>
                                                        @endif
                                                    @else
                                                        Agregar productos
                                                    @endif
                                                @endisset
                                            @endif
                                        </p>
                                    @else
                                        @if(isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$act->id]) && array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$act->id] > 1)
                                            <p class="text-decoration-none">
                                                Varios modelos
                                            </p>
                                        @else
                                            <p class="text-decoration-none">
                                                Ver detalle
                                            </p>
                                        @endif
                                    @endauth
                                @endif
                            </div>                        
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
        <div class="row">
            <div class="d-flex justify-content-center col-xs-12">
                <div class="col-sm-12 d-md-block">
                    <span class="">
                        <img src="{{ asset('img/todos_los_productos.jpg') }}" alt="Banner" class="mt-2"> 
                    </span>
                </div>
            </div>
            @foreach ($producto as $p)
                <div class="col-sm-6 col-md-4 col-lg-3 pb-3 pt-2">
                    @if (!isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id]))
                    <a id="a3" href="/detalle/{{ $p->id }}" class="link-dark disabledifempty">
                    @else
                    <a id="a3" href="/detalle/{{ $p->id }}" class="link-dark">
                    @endif
                        <div class="card cardhover position-relative top-50 start-50 translate-middle text-center text-dark" style="width: 210px; height: 420px;">
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
                            {{-- <img src="{{ asset('img'. '/' . '#'. '.jpg') }}" class="card-img-top img-fluid" alt="{{$p->modelo}}"> --}}
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
                                                                        if($minimo > $imgm->precio && $imgm->precio != 0) {
                                                                            $minimo = $imgm->precio;
                                                                        }else {
                                                                            $minimo = $minimo;
                                                                        }
                                                                    }
                                                                $min = "<strong class='text-danger'>Varios modelos desde USD " . $minimo . "</strong>";
                                                                echo $min;
                                                            @endphp
                                                        @else
                                                            <strong class="text-danger">USD {{ $p->producto->precio }}</strong></h4>
                                                        @endif
                                                    @else
                                                        Agregar productos
                                                    @endif
                                                @endisset
                                            @endif
                                        </p>
                                    @else
                                        @if( isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id]) && array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$p->id] > 1)
                                            <p class="text-decoration-none">
                                                Varios modelos
                                            </p>
                                        @else
                                            <p class="text-decoration-none">
                                                Ver detalle
                                            </p>
                                        @endif
                                    @endauth
                                @endif
                            </div>                        
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center py-3">
        {{ $producto->links() }}
    </div>
@endsection