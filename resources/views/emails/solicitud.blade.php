@component('mail::message')

# Solicitud de pedido de {{Auth::user()->name}}
# Contacto: {{Auth::user()->telefono}}

@component('mail::table')
|Nombre          |Modelo        |Precio Unitario            |Cantidad    |Subtotal    |
|:---------------|:-------------|:--------------------------|:-----------|:-----------|
@foreach ($carro as $c)
|  {{ $c->producto->titulo }}  |  {{$c->producto->modelo}}  |  {{ $c->producto->precio }}  |  {{ $c->qty }}  |  {{ $c->producto->precio * $c->qty }}  | 
@endforeach

@endcomponent

@component('mail::panel')
@php
$precioTotal = 0;
foreach ($carro as $c)
$precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;    
echo 'Subtotal: USD ' . $precioTotal
@endphp
<br>
@php
$precioTotal = 0;
foreach ($carro as $c)
$precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;    
echo 'IVA: USD ' . $precioTotal*0.22
@endphp
<br>
@php
$precioTotal = 0;
foreach ($carro as $c)
$precioTotal = ($c->producto->precio * $c->qty) + $precioTotal;    
echo 'Total a Facturar: USD ' . $precioTotal*1.22
@endphp
@endcomponent


@endcomponent