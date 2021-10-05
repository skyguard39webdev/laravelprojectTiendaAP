<nav class="navbar navbar-light navbar-expand-xl bg-light sticky-sm-top nav-pills flex-column flex-sm-row" style="background-image: url('{{ asset('img/fondo_1.jpg') }}');">
    <div class="container-fluid">
        <button class="btn btn-link link-lateral align-baseline mx-auto pt-3 pr-6 col-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
            <div class="container-fluid">
                <i class="fas fa-bars fa-2x"></i><p>Menu</p>
            </div>
        </button>
        <div class="d-flex justify-content-center col-6">
            <a class="navbar-brand abs mx-auto" href="/">
                <img src="{{ asset('img\aplogo.png') }}" alt="Logo" width="75" height="75" class="d-inline-block align-text-middle mr-4">
                <span class="d-none d-md-inline">Distribuidora AP</span>
            </a>
        </div>
        <button class="navbar-toggler mx-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end col-3" id="navbarTogglerDemo03">
            <ul class="navbar-nav">
                @if (Route::has('login'))
                    @isset (Auth::user()->name)
                        <li class="nav-item mr-5 py-2">
                            {{ 'Bienvenido ' . Auth::user()->name . '!'}}
                        </li>
                    @else
                        <li class="nav-item mr-5">
                            {{ 'Bienvenido Invitado!'}}
                        </li>
                    @endisset
                    {{-- <li class="nav-item"> --}}
                        @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            
                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{'Cerrar Sesión' }}
                            </x-responsive-nav-link>
                        </form>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="ml-4 text-sm text-gray-700 underline">Ingresar</a>
                            </li>
            
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Registrarse</a>
                                </li>
                            @endif
                        @endauth
                    {{-- </li> --}}
                @endif
            
            {{-- </div> --}}
            @if (Route::has('login'))
                @isset (Auth::user()->name)
                    <li class="nav-item ml-3 mr-3 py-2">
                        <a href="{{ route('showCarro') }}">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    </li>
                @endisset
            @endif
            </ul>
        </div>
    </div>
</nav>