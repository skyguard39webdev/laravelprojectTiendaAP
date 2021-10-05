@extends('layouts.app')

@section('prodna')
    <div class="container d-flex">
        <div class="row">
            @foreach ($producto as $p)
                <div class="col-4 pb-5">
                    <div class="card pr-5" style="width: 18rem; height: 24rem;">
                        <img src="{{ $p->imagen }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $p->nombre }}</h5>
                            <p class="card-text">{{ $p->descripcion }}</p>
                            <p class="card-text">{{ $p->categoria }}</p>
                            <div class="d-flex">
                                <a href="#" class="btn btn-primary position-absolute bottom-0 start-0 ml-3 mb-3">Vista Detallada</a>
                                @if (Route::has('login'))
                                    @auth
                                        <p class="position-absolute bottom-0 end-0 mr-3 mb-4">
                                            ${{ $p->precio }}
                                        </p>
                                    @else
                                        <p class="position-absolute bottom-0 end-0 mr-3 mb-4">
                                            Ingresar
                                        </p>
                                    @endauth
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="container">
        {{ $producto->links() }}
    </div>
@endsection
