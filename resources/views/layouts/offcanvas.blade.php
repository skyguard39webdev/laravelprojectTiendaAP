<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menú Principal</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul>
            <li>
                <a href="/" class="link-lateral">Inicio</a>
            </li>
        </ul>
        <hr>
        <ul>
            <li>
                <a href="/buscar" class="link-lateral">Buscar</a>
            </li>
        </ul>
        <hr>
        <div class="accordion accordion-flush" id="accordionOFFCANVAS">
            @foreach($categorias as $c)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$c->id}}">
                        <button class="accordion-button collapsed ml-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$c->id}}" aria-expanded="false" aria-controls="collapse{{$c->id}}">
                            {{$c->nombre}}
                        </button>
                    </h2>
                    <div id="collapse{{$c->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$c->id}}" data-bs-parent="#accordionOFFCANVAS">
                        <div class="accordion-body">
                            <ul>
                                @foreach ($subcategorias as $sc)
                                    @if ( $c->id == $sc->cat_id )
                                        <li class="mt-2"><a href="/productos/cat/{{$sc->id}}" class="link-lateral">{{$sc->nombre}}</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @if (Route::has('login'))
            @auth
                @isset(Auth::user()->rol_id)
                    @if (Auth::user()->rol_id == 4)
                        <div class="accordion accordion-flush" id="accordionEDIT">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingEDIT">
                                    <button class="accordion-button collapsed ml-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEDITAR" aria-expanded="false" aria-controls="collapseEDITAR">
                                        Editar contenido
                                    </button>
                                </h2>
                                <div id="collapseEDITAR" class="accordion-collapse collapse" aria-labelledby="headingEDIT" data-bs-parent="#accordionEDIT">
                                    <div class="accordion-body">
                                        <ul>
                                            <li class="mt-4" ><a href="/lista-usuarios" class="link-lateral">Lista de usuarios</a></li>
                                            <li class="mt-4" ><a href="/nuevo-producto" class="link-lateral">Ingresar Producto</a></li>
                                            <li class="mt-4" ><a href="/lista-productos-precio" class="link-lateral">Editar Precios de Productos</a></li>
                                            <li class="mt-4" ><a href="/lista-productos" class="link-lateral">Mostrar/Ocultar Productos</a></li>
                                            <li class="mt-4" ><a href="/nueva-cat" class="link-lateral">Ingresar Categoria</a></li>
                                            <li class="mt-4" ><a href="/editarCategoria" class="link-lateral">Editar Categoria</a></li>
                                            <li class="mt-4" ><a href="/nueva-subcat" class="link-lateral">Ingresar Subcategoria</a></li>
                                            <li class="mt-4" ><a href="/editarSubcategoria" class="link-lateral">Editar Subcategoria</a></li>
                                            <li class="mt-4" ><a href="/nuevo-sobremodelo" class="link-lateral">Ingresar Tarjeta</a></li>
                                            <li class="mt-4" ><a href="/eliminarSobremodelo" class="link-lateral">Eliminar Tarjeta</a></li>
                                            <li class="mt-4" ><a href="/editarSobremodelo" class="link-lateral">Editar Tarjeta</a></li>
                                            <li class="mt-4" ><a href="/lista-sobremodelos" class="link-lateral">Mostrar/Ocultar Tarjetas</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endisset
            @endauth
        @endif
    </div>
  </div>