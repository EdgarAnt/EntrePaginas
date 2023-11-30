@extends('layouts.temp')

@section('media')
<div class="container my-4">
    <h2 class="my-6 text-2xl font-semibold text-white dark:text-gray-200">Realizar Pago</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800">
        <!-- Inicio del formulario de pago -->
        <form action="{{ route('cart.process-payment') }}" method="POST">
            @csrf

            <label class="block text-sm">
                <span class="text-gray-700 dark:text-gray-400">Número de Tarjeta</span>
                <input type="text" name="card_number" class="form-input mt-1" placeholder="1111 2222 3333 4444" pattern="\d*" minlength="16" maxlength="16" required />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Fecha de Vencimiento</span>
                <input type="text" name="card_expiry" class="form-input mt-1" placeholder="MM/AA" pattern="\d{2}/\d{2}" required />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">CVV</span>
                <input type="text" name="card_cvv" class="form-input mt-1" placeholder="123" pattern="\d*" minlength="3" maxlength="3" required />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Nombre Completo</span>
                <input type="text" name="full_name" class="form-input mt-1" placeholder="Juan Pérez" required />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Dirección</span>
                <input type="text" name="address" class="form-input mt-1" placeholder="Calle Falsa 123" required />
            </label>

            <label class="block mt-4 text-sm">
                <span class="text-gray-700 dark:text-gray-400">Número de Teléfono</span>
                <input type="text" name="phone" class="form-input mt-1" placeholder="+521234567890" required />
            </label>

            <div class="py-4">
                <button type="submit" class="button-nav">
                    Realizar Pago
                </button>
            </div>
        </form>
        <!-- Fin del formulario de pago -->
    </div>
</div>
@endsection
