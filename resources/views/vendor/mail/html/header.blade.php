<tr>
<td class="header">
<a href="#" style="display: inline-block;">
@if (trim($slot) === 'TiendaAP')
<img src="{{ asset('img\aplogo.png') }}" class="logo" alt="AP Importador Logo">
@else
{{-- <img src="{{ asset('img/aplogo.png') }}" class="logo" alt="AP Logo"> --}}
{{-- <img src="{{ $message->embed(base_path() . '/img/aplogo.png') }}" /> --}}
@endif
</a>
</td>
</tr>
