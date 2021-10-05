@extends('layouts.app')

@section('error')
    <div class="container">
        <div class="">
            <p class="text-danger">Su solicitud de compra no ha podido ser enviada.</p>
            <br>
            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="/">
                {{ __('Pagina principal') }}
            </a>
        </div>
    </div>
@endsection