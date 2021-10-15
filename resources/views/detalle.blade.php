@extends('layouts.app')

@section('detalle')

    <div class="container">
        @if (isset($main_producto))
            <form method="POST" action="{{ route('carritoSaveProducto') }}">
                @csrf
                <div class="row">
                    @if(session()->has('advertenciaOculto'))
                        <div class="alert alert-danger mt-4">
                            {{ session()->get('advertenciaOculto') }}
                            {{ session()->forget('advertenciaOculto') }}
                        </div>
                    @endif
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
                        <input type="hidden" name="idProd" value="{{ $main_producto[0]->id }}" id="idProdView">
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
                        @if(session()->has('errorCrear'))
                            <div class="alert alert-danger mt-4">
                                {{ session()->get('errorCrear') }}
                            </div>
                        @endif
                        @if(session()->has('exitoCrear'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoCrear') }}
                            </div>
                        @endif
                        @if(session()->has('exitoMover'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoMover') }}
                            </div>
                        @endif
            </form>
                            
                        @isset(Auth::user()->rol_id)
                            @if (Auth::user()->rol_id == 4)
                                <form method="POST" action="{{ route('moverProductoTarjeta') }}">
                                    @csrf
                                    <div class="mt-3">
                                        <p><strong> Opciones de tarjeta: </strong></p>
                                        <div>
                                            <input type="radio" name="mc" id="c1A" onclick="habilitar()" value="0">
                                            <label for="c1">Crear nueva tarjeta</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="mc" id="m1A" onclick="habilitar()" value="1">
                                            <label for="m1">Mover a otra tarjeta</label>
                                        </div>
                                        <span id="crearA" class="mt-4">
                                            <label for="crear1" class="form-label">Escriba el nombre de la nueva tarjeta: </label>
                                            <input type="text" class="form-control" name="titulo" value="{{$main_producto[0]->sobremodelo->titulo}}" style="width: 400px;">
                                            <input type="hidden" name="id" value="{{$main_producto[0]->id}}">
                                            <input type="hidden" name="accion" value="0" id="accioncrearA">
                                        </span>
                                        <span id="moverA" class="mt-4">
                                            <label for="mover1A" class="form-label">Tarjeta: </label>
                                            <select id="mover1A" class="form-select" name="sobremodelo_id" required style="width: 200px;">
                                                <option selected>Seleccionar tarjeta</option>
                                                @foreach($sobremodelos as $sm)
                                                <option value="{{$sm->id}}"> {{$sm->titulo}} </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id" value="{{$main_producto[0]->id}}">
                                            <input type="hidden" name="accion" value="1" id="accionmoverA">
                                        </span>
                                        <div>
                                            <x-button class="mt-4" id="botonmcA">
                                                {{ __('Confirmar') }}
                                            </x-button>
                                        </div>
                                    </div>
                                    
                                    <script type="text/javascript">
                                        function habilitar() {
                                            var radioCrear = document.getElementById("c1A");
                                            var radioMover = document.getElementById("m1A");
                                            var spanCrear = document.getElementById("crearA");
                                            var spanMover = document.getElementById("moverA");
                                            var boton = document.getElementById("botonmcA");
                                            var accionCrear = document.getElementById("accioncrearA");
                                            var accionMover = document.getElementById("accionmoverA");

                                            if (radioCrear.checked) {
                                                spanMover.style.display = 'none';
                                                spanMover.disabled = true;
                                                spanCrear.style.display = '';
                                                spanCrear.disabled = false;
                                                boton.style.display = '';
                                                accionCrear.disabled = false;
                                                accionMover.disabled = true;
                                            } else if (radioMover.checked){
                                                spanCrear.style.display = 'none';
                                                spanCrear.disabled = true;
                                                spanMover.style.display = '';
                                                spanMover.disabled = false;
                                                boton.style.display = '';
                                                accionCrear.disabled = true;
                                                accionMover.disabled = false;
                                            } else {
                                                spanCrear.style.display = 'none';
                                                spanCrear.disabled = true;
                                                spanMover.style.display = 'none';
                                                spanMover.disabled = true;
                                                boton.style.display = 'none';
                                                accionCrear.disabled = true;
                                                accionMover.disabled = true;
                                            }
                                            
                                        }
                                        document.onload = habilitar();
                                    </script>
                                </form>
                            @endif
                        @endisset
                        <div class="mt-6 col-4">
                            <p id="otrosModelos"><strong> Otros modelos: </strong></p>
                            <ul class="list-group">
                            @foreach ($producto as $prod)
                                {{-- @if ($prod->oculto != 1) --}}
                                <input type="hidden" id="idLink{{$prod->id}}" value="{{$prod->id}}">
                                <li id="link{{$prod->id}}" class="list-group-item">
                                    <a  id="click{{$prod->id}}" class="underline text-sm text-dark" href="/detalle/{{ $prod->id }}/{{$prod->sobremodelo_id }}">{{$prod->titulo . ' Modelo: '}} <strong>{{$prod->modelo}}</strong></a>
                                </li>
                                {{-- @endif --}}
                            @endforeach
                            </ul>
                        </div>
                {{-- el siguiente div cierra un div.row mas arriba --}}
                </div>
                <script type="text/javascript">
                    function checkLink() {
                        var productos = <?php echo json_encode($producto); ?>;
                        var i = 0;
                        var contarOcultos = 0;
                        for (var p in productos) {
                            if (i <= productos.length) {
                                console.log(i);
                                var modeloOpcional = document.getElementById("link" + productos[i].id);
                                var idProdLink = document.getElementById("idLink" + productos[i].id);
                                var idProdView = document.getElementById("idProdView");
                                var otrosModelos = document.getElementById("otrosModelos");
                                var link = document.getElementById("click"  + productos[i].id);
                                

                                if (productos[i].oculto == 1){
                                    contarOcultos++;
                                }
                                
                                if(idProdLink.value == idProdView.value){
                                    // modeloOpcional.style.display = 'none';
                                    modeloOpcional.classList.add("active");
                                    modeloOpcional.classList.add("text-light");
                                    link.classList.remove("text-dark");
                                    link.classList.add("text-white");
                                    link.classList.add("disabledifempty");
                                    // modeloOpcional.disabled = true;
                                }

                                if (productos.length <= 1 || productos.length == contarOcultos || productos[i].oculto == 1){
                                    otrosModelos.style.display = 'none';
                                    modeloOpcional.style.display = 'none';
                                }
                            }
                            i++;

                        }
                    }
                    document.onload = checkLink();
                </script>
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
                        <input type="hidden" name="idProd" value="{{ $producto[0]->id }}" id="idProdView">
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
                        @if(session()->has('errorCrear'))
                            <div class="alert alert-danger mt-4">
                                {{ session()->get('errorCrear') }}
                            </div>
                        @endif
                        @if(session()->has('exitoCrear'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoCrear') }}
                            </div>
                        @endif
                        @if(session()->has('exitoMover'))
                            <div class="alert alert-success mt-4">
                                {{ session()->get('exitoMover') }}
                            </div>
                        @endif
            </form>
                            
                        @isset(Auth::user()->rol_id)
                            @if (Auth::user()->rol_id == 4)
                                <form method="POST" action="{{ route('moverProductoTarjeta') }}">
                                    @csrf
                                    <div class="mt-4">
                                        <p><strong> Opciones de tarjeta: </strong></p>
                                        <div>
                                            <input type="radio" name="mc" id="c1B" onclick="habilitar()" value="0">
                                            <label for="c1">Crear nueva tarjeta</label>
                                        </div>
                                        <div>
                                            <input type="radio" name="mc" id="m1B" onclick="habilitar()" value="1">
                                            <label for="m1">Mover a otra tarjeta</label>
                                        </div>
                                        <span id="crearB" class="mt-4">
                                            <label for="crear1" class="form-label">Escriba el nombre de la nueva tarjeta: </label>
                                            <input type="text" class="form-control" name="titulo" value="{{$producto[0]->sobremodelo->titulo}}" style="width: 400px;">
                                            <input type="hidden" name="id" value="{{$producto[0]->id}}">
                                            <input type="hidden" name="accion" value="0" id="accioncrearB">
                                        </span>
                                        <span id="moverB" class="mt-4">
                                            <label for="mover1B" class="form-label">Tarjeta: </label>
                                            <select id="mover1B" class="form-select" name="sobremodelo_id" required style="width: 200px;">
                                                <option selected>Seleccionar tarjeta</option>
                                                @foreach($sobremodelos as $sm)
                                                <option value="{{$sm->id}}"> {{$sm->titulo}} </option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="id" value="{{$producto[0]->id}}">
                                            <input type="hidden" name="accion" value="1" id="accionmoverB">
                                        </span>
                                        <div>
                                            <x-button class="mt-4" id="botonmcB">
                                                {{ __('Confirmar') }}
                                            </x-button>
                                        </div>
                                    </div>
                                    
                                    <script type="text/javascript">
                                        function habilitar() {
                                            var radioCrear = document.getElementById("c1B");
                                            var radioMover = document.getElementById("m1B");
                                            var spanCrear = document.getElementById("crearB");
                                            var spanMover = document.getElementById("moverB");
                                            var boton = document.getElementById("botonmcB");
                                            var accionCrear = document.getElementById("accioncrearB");
                                            var accionMover = document.getElementById("accionmoverB");
                                            

                                            if (radioCrear.checked) {
                                                spanMover.style.display = 'none';
                                                spanMover.disabled = true;
                                                spanCrear.style.display = '';
                                                spanCrear.disabled = false;
                                                boton.style.display = '';
                                                accionCrear.disabled = false;
                                                accionMover.disabled = true;
                                            } else if (radioMover.checked){
                                                spanCrear.style.display = 'none';
                                                spanCrear.disabled = true;
                                                spanMover.style.display = '';
                                                spanMover.disabled = false;
                                                boton.style.display = '';
                                                accionCrear.disabled = true;
                                                accionMover.disabled = false;
                                            } else {
                                                spanCrear.style.display = 'none';
                                                spanCrear.disabled = true;
                                                spanMover.style.display = 'none';
                                                spanMover.disabled = true;
                                                boton.style.display = 'none';
                                                accionCrear.disabled = true;
                                                accionMover.disabled = true;
                                            }
                                            
                                        }
                                        document.onload = habilitar();
                                    </script>
                                </form>
                            @endif
                        @endisset

                        <div class="mt-6 col-4">
                            <p id="otrosModelos"><strong> Otros modelos: </strong></p>
                            <ul class="list-group">
                            @foreach ($producto as $prod)
                                @if ($prod->oculto != 1)
                                <li id="link{{$prod->id}}" class="list-group-item">
                                    <input type="hidden" id="idLink{{$prod->id}}" value="{{$prod->id}}">
                                    <a  id="click{{$prod->id}}" class="underline text-sm text-dark" href="/detalle/{{ $prod->id }}/{{$prod->sobremodelo_id }}">{{$prod->titulo . ' Modelo: '}} <strong>{{$prod->modelo}}</strong></a>
                                </li>
                                @endif
                            @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    function checkLink() {
                        var productos = <?php echo json_encode($producto); ?>;
                        var i = 0;
                        var contarOcultos = 0;
                        for (var p in productos) {
                            if (i <= productos.length) {
                                console.log(i);
                                var modeloOpcional = document.getElementById("link" + productos[i].id);
                                var idProdLink = document.getElementById("idLink" + productos[i].id);
                                var idProdView = document.getElementById("idProdView");
                                var otrosModelos = document.getElementById("otrosModelos");
                                var link = document.getElementById("click"  + productos[i].id);
                                

                                if (productos[i].oculto == 1){
                                    contarOcultos++;
                                }
                                
                                if(idProdLink.value == idProdView.value){
                                    // modeloOpcional.style.display = 'none';
                                    modeloOpcional.classList.add("active");
                                    modeloOpcional.classList.add("text-light");
                                    link.classList.remove("text-dark");
                                    link.classList.add("text-white");
                                    link.classList.add("disabledifempty");
                                    // modeloOpcional.disabled = true;
                                }

                                if (productos.length <= 1 || productos.length == contarOcultos || productos[i].oculto == 1){
                                    otrosModelos.style.display = 'none';
                                    modeloOpcional.style.display = 'none';
                                }
                            }
                            i++;

                        }
                    }
                    document.onload = checkLink();
                </script>
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
                                                                $min = '';
                                                                if ($minimo == 1000000000000){
                                                                    $min = "<strong class='text-danger'>AGOTADO</strong>";
                                                                } else{
                                                                    $min = "<strong class='text-danger'>USD " . $minimo . "</strong>";
                                                                }
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