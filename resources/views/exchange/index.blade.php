@extends('layouts.temp')

@section('media')
<div class="container my-4">
    <h1 class="text-center mb-4 text-white">Ofertas de Intercambio</h1>

    @if(session('success'))
    <div class="button-nav">
        {{ session('success') }}
    </div>
@endif

@if(session('message'))
    <div class="button-nav">
        {{ session('message') }}
    </div>
@endif

@if(session('error'))
    <div class="button-nav">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="button-nav">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- Ofertas Enviadas --}}
    <section>
        <h2 class="text-center mb-4 text-white">Tus Ofertas Enviadas</h2>
        <div class="row">
            @forelse ($sentExchanges as $exchange)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow text-white bg-dark">
                        {{-- Asumiendo que 'image_path' es un atributo del modelo 'Exchange' --}}
                        <img src="{{ $exchange->image_path ? asset($exchange->image_path) : asset('default-book-image.jpg') }}" class="card-img-top img-fluid" alt="{{ $exchange->title }}" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $exchange->title }}</h5>
                            <p class="card-text">{{ $exchange->description }}</p>
                            <p class="card-text"><strong>Estado:</strong> {{ $exchange->status }}</p>
                            <a href="{{ route('exchanges.show', $exchange->id) }}" class="btn btn-primary mt-auto">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-white">No has enviado ofertas de intercambio.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- Ofertas Recibidas --}}
    <section>
        <h2 class="text-center mb-4 text-white">Ofertas Recibidas</h2>
        <div class="row">
            @forelse ($receivedExchanges as $exchange)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow text-white bg-dark">
                        {{-- Asumiendo que 'image_path' es un atributo del modelo 'Exchange' --}}
                        <img src="{{ $exchange->image_path ? asset($exchange->image_path) : asset('default-book-image.jpg') }}" class="card-img-top img-fluid" alt="{{ $exchange->title }}" style="max-height: 200px; object-fit: cover;">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $exchange->title }}</h5>
                            <p class="card-text">{{ $exchange->description }}</p>
                            <p class="card-text"><strong>Solicitante:</strong> {{ $exchange->requester->name }}</p>
                            <a href="{{ route('exchanges.show', $exchange->id) }}" class="button-nav">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center text-white">No has recibido ofertas de intercambio.</p>
                </div>
            @endforelse
        </div>
    </section>
</div>

@endsection
