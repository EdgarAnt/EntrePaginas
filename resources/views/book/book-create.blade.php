{{-- resources/views/book/create.blade.php --}}

@extends('layouts.temp')

@section('media')

<div class="container">
    <h1>Solicitar Intercambio de Libro</h1>
    
    <form action="{{ route('book_exchanges.store') }}" method="POST" enctype="multipart/form-data">
        @csrf {{-- Protección contra CSRF --}}
        
        {{-- Campo oculto para el ID del libro que se quiere intercambiar --}}
        <input type="hidden" name="requested_content_id" value="{{ $content->id }}">

        <div class="mb-3">
            <label for="title" class="form-label">Título de tu libro:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        
        <div class="mb-3">
            <label for="author" class="form-label">Autor de tu libro:</label>
            <input type="text" class="form-control" id="author" name="author" required>
        </div>
        
        <div class="mb-3">
            <label for="isbn" class="form-label">ISBN de tu libro (opcional):</label>
            <input type="text" class="form-control" id="isbn" name="isbn">
        </div>
        
        <div class="mb-3">
            <label for="condition" class="form-label">Condición de tu libro:</label>
            <select class="form-control" id="condition" name="condition" required>
                <option value="">Selecciona una condición</option>
                <option value="new">Nuevo</option>
                <option value="like_new">Como nuevo</option>
                <option value="good">Bueno</option>
                <option value="fair">Aceptable</option>
                <option value="poor">Pobre</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Descripción de tu libro:</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        
        {{-- Campo para subir la imagen del libro --}}
        <div class="mb-3">
            <label for="image" class="form-label">Imagen de tu libro (opcional):</label>
            <input type="file" class="form-control" id="image" name="image">
        </div>
        
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
    </form>
</div>

@endsection
