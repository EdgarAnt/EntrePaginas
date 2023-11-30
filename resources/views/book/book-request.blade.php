{{-- resources/views/book/requests.blade.php --}}

@extends('layouts.temp')

@section('media')
<div class="container">
    <h1>Mis Solicitudes de Intercambio</h1>
    @forelse($userExchanges as $exchange)
        <div class="card mb-3">
            <div class="card-header">{{ $exchange->requestedBook->title }}</div>
            <div class="card-body">
                <h5 class="card-title">Solicitante: {{ $exchange->requester->name }}</h5>
                <p class="card-text">{{ $exchange->message }}</p>
                <!-- Agregar botones de acción aquí -->
            </div>
        </div>
    @empty
        <p>No tienes solicitudes de intercambio pendientes.</p>
    @endforelse
</div>
@endsection
