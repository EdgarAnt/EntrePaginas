@extends('layouts.temp')

@section('media')
<div class="container">
    <h1>Mis Intercambios</h1>

    <h2>Solicitudes Realizadas</h2>
    @if($userExchanges->isEmpty())
        <p>No has realizado ninguna solicitud de intercambio todavía.</p>
    @else
        @foreach($userExchanges as $exchange)
            {{-- Muestra información sobre las solicitudes hechas por el usuario --}}
        @endforeach
    @endif

    <h2>Solicitudes Recibidas</h2>
    @if($receivedExchanges->isEmpty())
        <p>No tienes solicitudes de intercambio pendientes.</p>
    @else
        @foreach($receivedExchanges as $exchange)
            {{-- Muestra información sobre las solicitudes recibidas por el usuario --}}
        @endforeach
    @endif
</div>
@endsection
