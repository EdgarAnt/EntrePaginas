@extends('layouts.temp')

@section('media')
<div class="container my-4">
    <!-- Mensajes de retroalimentación -->
    @if(session('success'))
        <div class="button-nav" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="button-nav" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @php $total = 0; @endphp

    <h1 class="text-center text-white mb-4">Carrito de Compras</h1>
    @if(isset($cart) && $cart->cartItems->isNotEmpty())
        <div class="row">
            @foreach($cart->cartItems as $cartItem)
                @php
                    $itemTotal = $cartItem->quantity * $cartItem->content->price; // Asegúrate de que el precio está disponible en el modelo de contenido.
                    $total += $itemTotal;
                @endphp
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <img src="{{ asset($cartItem->content->image_path) }}" class="card-img-top" alt="{{ $cartItem->content->title }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $cartItem->content->title }}</h5>
                            <p class="card-text">Cantidad: {{ $cartItem->quantity }}</p>
                            <p class="card-text">Precio: ${{ number_format($itemTotal, 2) }} MXN</p>
                            <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="mb-2">
                                @csrf
                                @method('PATCH')
                                <div class="input-group">
                                    <input type="number" name="quantity" value="{{ $cartItem->quantity }}" min="1" class="form-control" style="color: black; background-color: white;" aria-label="Cantidad">
                                    <div class="input-group-append">
                                        <button class="button-nav" type="submit">Actualizar</button>
                                    </div>
                                </div>
                            </form>
                            <form action="{{ route('cart.remove', $cartItem->content_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button-nav">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-right text-white">
            <h4>Total: ${{ number_format($total, 2) }} MXN</h4>
            <a href="{{ route('checkout.index') }}" class="button-nav">Proceder a la compra</a>
            
        </div>

        <div class="text-right">
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                <button type="submit" class="button-nav">Vaciar Carrito</button>
            </form>
        </div>
    @else
        <p class="text-center text-white">Tu carrito está vacío.</p>
    @endif
    
    <style>
        
    </style>
    
</div>

@endsection
