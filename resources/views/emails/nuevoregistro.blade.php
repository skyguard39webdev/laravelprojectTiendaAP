@component('mail::message')
# Nuevo Registro en su Web

Este correo se generó automaticamente dado que se registró un nuevo cliente en su página.

@component('mail::table')
|Nombre          |Celular            |Correo    |
|:---------------|:------------------|:---------|
| {{ $usuario->name }} | {{ $usuario->telefono }} | {{ $usuario->email }} |
@endcomponent



@endcomponent
