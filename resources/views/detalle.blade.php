@extends('layouts.app')

@section('detalle')

    <div class="container">
        @if (isset($main_producto))
            <form method="POST" action="{{ route('carritoSaveProducto') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <img src="{{ asset('img'. '/' . $main_producto[0]->modelo .'.jpg') }}" alt="{{ $main_producto[0]->modelo }}" width="500" height="500">
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <br>
                        <br>
                        <br>
                        <h1>{{ $main_producto[0]->titulo }}</h1>
                        <h5>Modelo: <strong> {{ $main_producto[0]->modelo }}</strong></h5>
                        @if($main_producto[0]->marca == null)
                            <h5>Marca: <strong> generica</strong></h5>
                        @else
                            <h5>Marca: <strong> {{ $main_producto[0]->marca }}</strong></h5>
                        @endif
                        <p>{{ $main_producto[0]->descripcion }}</p>
                        <input type="hidden" name="idProd" value="{{ $main_producto[0]->id }}">
                        @if (Route::has('login'))
                            @auth
                                @isset(Auth::user()->rol_id)
                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4)
                                        @if($main_producto[0]->precio <= 0)
                                            <h4><strong class="text-danger">AGOTADO</strong></h4>
                                        @else
                                            <h4>Precio: <strong class="text-danger">USD {{ $main_producto[0]->precio }} </strong></h4>
                                        @endif
                                        @if ($main_producto[0]->precio > 0)
                                            <h6 class="text-danger">(No incluye IVA)</h6>
                                        @endif
                                        <div class="d-flex">
                                            @if($main_producto[0]->precio <= 0)
                                                <br>
                                            @else
                                                <input type="number" name="qty" value="1" />
                                                <x-button class="ml-4">
                                                    {{ __('Agregar al carrito') }}
                                                </x-button>
                                            @endif
                                            @if (Auth::user()->rol_id == 4)
                                                <a href="/editarProducto/{{$main_producto[0]->id}}" class="underline text-sm text-gray-600 hover:text-gray-900 ml-4 pt-2">Editar producto</a>
                                                <a href="/eliminarProducto/{{$main_producto[0]->id}}" class="underline text-sm text-gray-600 hover:text-gray-900 ml-4 pt-2">Eliminar producto</a>
                                            @endif
                                        </div>
                                    @endif
                                @endisset    
                            @endauth
                        @endif
                        @if(session()->has('exitoCarrito'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoCarrito') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger mt-4">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="dropdown mt-4">
                            <x-button class="no-click">Modelos</x-button>
                            <div class="dropdown-content">
                                @foreach ($producto as $prod)
                                    @if ($prod->oculto != 1)
                                        <a href="/detalle/{{ $prod->id }}/{{$prod->sobremodelo_id }}">{{$prod->sobremodelo->titulo . ' - ' . $prod->modelo}}</a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @else
            <form method="POST" action="{{ route('carritoSaveProducto') }}">
                @csrf
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <img src="{{ asset('img'. '/' . $producto[0]->modelo .'.jpg') }}" alt="{{ $producto[0]->modelo }}" width="500" height="500">
                    </div>
                    <div class="col-lg-8 col-sm-12">
                        <br>
                        <br>
                        <br>
                        <h1>{{ $producto[0]->titulo }}</h1>
                        <h5>Modelo: <strong> {{ $producto[0]->modelo }}</strong></h5>
                        @if($producto[0]->marca == null)
                            <h5>Marca: <strong> generica</strong></h5>
                        @else
                            <h5>Marca: <strong> {{ $producto[0]->marca }}</strong></h5>
                        @endif
                        <p>{{ $producto[0]->descripcion }}</p>
                        <input type="hidden" name="idProd" value="{{ $producto[0]->id }}">
                        @if (Route::has('login'))
                            @auth
                                @isset(Auth::user()->rol_id)
                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4)
                                        @if($producto[0]->precio <= 0)
                                            <h4><strong class="text-danger">AGOTADO</strong></h4>
                                        @else
                                            <h4>Precio: <strong class="text-danger">USD {{ $producto[0]->precio }} </strong></h4>
                                        @endif
                                        @if ($producto[0]->precio > 0)
                                            <h6 class="text-danger">(No incluye IVA)</h6>
                                        @endif
                                        <div class="d-flex">
                                            @if($producto[0]->precio <= 0)
                                                <br>
                                            @else
                                                <input type="number" name="qty" value="1" />
                                                <x-button class="ml-4">
                                                    {{ __('Agregar al carrito') }}
                                                </x-button>
                                            @endif
                                            @if (Auth::user()->rol_id == 4)
                                                <a href="/editarProducto/{{$producto[0]->id}}" class="underline text-sm text-gray-600 hover:text-gray-900 ml-4 pt-2">Editar producto</a>
                                                <a href="/eliminarProducto/{{$producto[0]->id}}" class="underline text-sm text-gray-600 hover:text-gray-900 ml-4 pt-2">Eliminar producto</a>
                                            @endif
                                        </div>
                                    @endif
                                @endisset    
                            @endauth
                        @endif
                        @if(session()->has('exitoCarrito'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoCarrito') }}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger mt-4">
                                {{ session()->get('error') }}
                            </div>
                        @endif
                        <div class="dropdown mt-4">
                            <x-button class="no-click">Modelos</x-button>
                            <div class="dropdown-content" id="scrollbar1">
                                @foreach ($producto as $prod)
                                    @if ($prod->oculto != 1)
                                        <a href="/detalle/{{ $prod->id }}/{{$prod->sobremodelo_id }}">{{$prod->sobremodelo->titulo . ' - ' . $prod->modelo}}</a>
                                    @endif  
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        @endif
        <br>
        <div class="row">
            <div class="d-flex justify-content-center col-12">
                <div class="col-sm-12 d-none d-md-block">
                    <span class="">
                        <img src="{{ asset('img/productos_destacados_1.jpg') }}" alt="Banner" class="mt-2"> 
                    </span>
                </div>
            </div>
            @foreach ($recomendados as $r)
                <div class="col-sm-6 col-md-4 col-lg-3 pb-3 pt-2">
                    <div class="card cardhover position-relative top-50 start-50 translate-middle" style="width: 210px; height: 470px;">
                        @if (!isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id]))
                        <a href="/detalle/{{ $r->id }}" class="link-dark disabledifempty">
                        @else
                        <a href="/detalle/{{ $r->id }}" class="link-dark">
                        @endif
                            @php
                                $modelo = '';
                                foreach ($imgModelos as $imgm)
                                    if($r->titulo == $imgm->sobremodelo->titulo) {
                                        $modelo = $imgm->modelo;
                                    } else {
                                        $modelo = $modelo;
                                    }
                                $url = "img" . "/" . $modelo . ".jpg";
                                $img = "<img src='" . asset($url) . "' class='card-img-top img-fluid' alt='" . $r->modelo . "'>";
                                echo $img;
                            @endphp
                            <div class="card-body">
                                <h5 class="card-title">{{ $r->titulo }}</h5>
                                @if (Route::has('login'))
                                    @auth
                                        <p class="text-decoration-none">
                                            @if (Route::has('login'))
                                                @isset (Auth::user()->rol_id)
                                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 4 && isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id]))
                                                        @if(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id] > 1)
                                                            @php
                                                                $minimo = 1000000000000;
                                                                foreach ($imgModelos as $imgm)
                                                                    if($r->titulo == $imgm->sobremodelo->titulo) {
                                                                        if($minimo > $imgm->precio && $imgm->precio != 0 && $imgm->oculto == 0) {
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
                                                                    if($r->titulo == $imgm->sobremodelo->titulo ) {
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
                                        @if(isset(array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id]) && array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id] > 1)
                                            <p class="text-decoration-none">
                                                Varios modelos
                                            </p>
                                        {{-- @elseif (array_count_values(array_column($imgModelos->all(), 'sobremodelo_id'))[$r->id] == 1)
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
            @endforeach
        </div>
    </div>
@endsection