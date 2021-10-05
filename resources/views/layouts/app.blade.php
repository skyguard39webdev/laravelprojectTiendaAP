<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow, noarchive, max-snippet:-1">
        <meta name="description" content="Artículos de caza, pesca, camping y mucho más, al por mayor">
        <meta property="og:locale" content="es_ES" />
        <meta property="og:type" content="website" />
        <meta property="og:title" content="Distribuidora AP - Artículos de caza, pesca, camping y mucho más, al por mayor" />
        <meta property="og:description" content="Artículos de caza, pesca, camping y mucho más, al por mayor" />
        <meta property="og:url" content="{{ Request::url() }}" />
        <meta property="og:site_name" content="Distribuidora AP" />
        <meta name="twitter:card" content="summary_large_image" />

        <title>Distribuidora AP</title>
        <link rel="icon" href="{{ asset('img/ap_favicon.png') }}" type="image/png">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">

        {{-- estilos para slider --}}
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Anton' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Neucha' rel='stylesheet' type='text/css'>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://kit.fontawesome.com/d5fbf70475.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        {{-- <script src="{{ asset('js/customjs.js') }}" defer></script> --}}
    </head>
    <body class="bg-light">
        <div class="min-h-screen bg-gray-100" style="background-image: url('{{ asset('img/fondo_grande.jpg') }}');">
            @include('layouts.navbar')

            <!-- Page Heading -->
            <header class="bg-white">
                @if(request()->is('/'))
                    @include('layouts.slide')
                @endif
                
            </header>
            {{-- @if(request()->is('/'))
                @include('layouts.slide')
            @endif --}}
            <!-- Page Content -->
            <main>
                <div class="d-flex">
                    @include('layouts.offcanvas')
                    <div class="col-12">
                        <div class="row">
                            @yield('contacto')
                            @yield('detalle')
                            @yield('prod')
                            @yield('prodCat0')
                            @yield('upriv')
                            @yield('carro')
                            @yield('exito')
                            @yield('error')
                            @yield('nuevoprodpriv')
                            @yield('nuevosubcatpriv')
                            @yield('nuevocatpriv')
                            @yield('updateprodpriv')
                            @yield('buscarprod')
                            @yield('nuevosobremod')
                            @yield('elimProd')
                            @yield('elimSobremodelo')
                        </div>
                    </div>
                </div>
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>