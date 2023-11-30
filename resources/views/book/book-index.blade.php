@extends('layouts.temp')

@section('media')
<div class="container">
    <h1>Mis Libros Ofrecidos</h1>
    
    @forelse($offeredBooks as $book)
        <div class="list-group-item">
            <h5 class="mb-1">{{ $book->title }}</h5>
            <p class="mb-1">Descripción: {{ $book->description }}</p>
            <p class="mb-1">Te ofrecen este libro por el libro: {{ $book->exchangeForContent->title ?? 'No especificado' }}</p>
            <small class="text-muted">Estado: {{ $book->condition }}</small>
        </div>
    @empty
        <p>No has ofrecido ningún libro todavía.</p>
    @endforelse
</div>
@endsection
