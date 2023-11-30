@extends('layouts.temp')

@section('media')
    <div class="container mx-auto my-8">
        <h1 class="text-white text-2xl font-bold mb-4">Resultados de la Búsqueda</h1>
        @if($results->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($results as $result)
                    <div class="bg-gray-800 p-5 rounded-lg shadow-md">
                        <a href="{{ route('content.show', $result->id) }}">
                            <img style="height: 15rem;width:max-content;object-fit: cover;" src="{{ asset($result->image_path) }}" alt="{{ $result->title }}" 
                        </a>
                        <div class="text-white">
                            <h2 class="text-xl font-semibold mb-2">Titulo: {{ $result->title }}</h2>
                            <p class="mb-4">Descripcion  {{ Str::limit($result->description, 150) }}</p>
                            <p>ISBN: {{ $result->isbn }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-white">No se encontraron resultados para tu búsqueda.</p>
        @endif
    </div>
@endsection
