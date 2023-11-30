@extends('layouts.temp')

@section('media')
<div class="container mt-4">
    <h1 class="text-center mb-4 text-white">Detalles del Intercambio</h1>

    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs mb-4">
        <div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
            <div class="md:col-span-1 xl:col-span-1">
                <!-- Suponemos que hay una imagen disponible -->
                @if($exchange->image_path)
                    <img src="{{ asset($exchange->image_path) }}" alt="Imagen del intercambio" class="rounded-lg shadow-xs">
                @endif
            </div>
            <div class="md:col-span-1 xl:col-span-3">
                <div class="p-4 bg-gray-100 rounded-lg shadow-xs">
                    <h5 class="text-lg font-semibold text-gray-700">{{ $exchange->title }}</h5>
                    <p class="text-gray-600">{{ $exchange->description }}</p>
                    <p class="text-gray-600"><strong>Autor:</strong> {{ $exchange->author }}</p>
                    <p class="text-gray-600"><strong>Editorial:</strong> {{ $exchange->publisher }}</p>
                    <p class="text-gray-600"><strong>ISBN:</strong> {{ $exchange->isbn }}</p>
                    <p class="text-gray-600"><strong>Condición:</strong> {{ $exchange->condition }}</p>
                    <p class="text-gray-600"><strong>Mensaje del Solicitante:</strong> {{ $exchange->offer_message }}</p>
                    <p class="text-gray-600"><strong>Estado de la Oferta:</strong> {{ $exchange->status }}</p>
                </div>
            </div>
        </div>

    @if(auth()->check())
        {{-- Si el usuario es el dueño o el solicitante y la oferta ha sido aceptada --}}
        @if(($exchange->status === 'accepted') && (auth()->id() === $exchange->owner_user_id || auth()->id() === $exchange->requester_user_id))
            <div class="text-center mb-4">
                <h3 class="text-white">Ingresar Datos de contacto</h3>
                <form action="{{ route('exchanges.address', $exchange->id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" name="address" placeholder="Dirección completa" required>
                        <input type="text" class="text" name="address" placeholder="Telefono" required>
                        <input type="text" class="email" name="address" placeholder="Correo Eelectronico" required>


                    </div>
                    <button type="submit" class="btn btn-primary button-nav">Enviar </button>
                   
                </form>
            </div>
        @elseif($exchange->status === 'pending' && auth()->id() === $exchange->owner_user_id)
            <div class="text-center mb-4">
                {{-- Botones para aceptar o rechazar la oferta --}}
                <form action="{{ route('exchanges.accept', $exchange->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="button-nav">Aceptar Oferta</button>
                </form>
                <form action="{{ route('exchanges.reject', $exchange->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="button-nav">Rechazar Oferta</button>
                </form>
            </div>
        @endif
    @endif

        @if($exchange->status === 'pending' && auth()->id() === $exchange->requester_user_id)
        <div class="text-center mb-4">
            {{-- Botón para cancelar la solicitud de intercambio --}}
            <form action="{{ route('exchanges.cancel', $exchange->id) }}" method="POST">
                @csrf
                <button type="submit" class="button-nav">Cancelar Solicitud</button>
            </form>
        </div>
    @endif
    @if(in_array($exchange->status, ['cancelled', 'rejected']) && auth()->id() === $exchange->requester_user_id)
    <div class="text-center mb-4">
        {{-- Botón para eliminar la oferta rechazada o cancelada --}}
        <form action="{{ route('exchanges.destroy', $exchange->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger button-nav">Eliminar Oferta</button>
        </form>
    </div>
    @endif


    <div class="text-center">
        <a href="{{ route('exchanges.index') }}" class="button-nav">Volver a Ofertas</a>
    </div>
</div>
</div>


<style>
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.min-w-0 {
    min-width: 0;
}

.bg-white {
    background-color: #3e3a3a;
}

.rounded-lg {
    border-radius: 0.5rem;
}

.shadow-xs {
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
}

.grid {
    display: grid;
}

.gap-6 {
    grid-gap: 1.5rem;
}

.bg-gray-100 {
    background-color: #1f2326;
}

.text-gray-600 {
    color: #718096;
}

.text-lg {
    font-size: 1.125rem;
}

.font-semibold {
    font-weight: 600;
}

.text-white {
    color: #f3f3f3;
}

.btn-outline-primary {
    border: 1px solid #2c5282;
    color: #2c5282;
}

.btn-outline-primary:hover {
    background-color: #111923;
    color: #0e0808;
}

@media (max-width: 768px) {
    .grid {
        grid-template-columns: 1fr;
    }
}
</style>

@endsection
