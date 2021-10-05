@extends('layouts.app')

@section('exito')
    <div class="container">
        <div class="">
            <p>Su solicitud de compra ha sido enviada con exito y está siendo procesada. En breve el vendedor se comunicará con Ud. a la brevedad.</p>
            <br>
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                {{ __('Pagina principal') }}
            </a>
        </div>
    </div>
@endsection