@extends('layouts.temp')

@section('media')
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-white mb-6">Resultados de la Búsqueda</h1>
        
        @if($results->isEmpty())
            <p class="text-white">No se encontraron resultados para tu búsqueda.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($results as $result)
                    <div class="bg-white rounded-lg overflow-hidden shadow-lg">
                        <a href="{{ route('content.show', $result->id) }}">
                            <img src="{{ asset($result->image_path) }}" alt="{{ $result->title }}" class="w-full h-64 object-cover">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('content.show', $result->id) }}" class="text-lg font-bold hover:underline">{{ $result->title }}</a>
                            <p class="text-gray-700 mt-2">{{ Str::limit($result->description, 100) }}</p>
                            <p class="text-gray-600 mt-2">ISBN: {{ $result->isbn }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
