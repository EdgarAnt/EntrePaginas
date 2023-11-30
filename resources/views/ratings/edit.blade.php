@extends('layouts.temp')

@section('media')
    <div class="container mx-auto px-4 sm:px-8">
        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200 mb-6">Editar Comentario y Calificación</h1>

        @can('update', $rating)
            <form action="{{ route('content.ratings.update', ['content' => $rating->content_id, 'rating' => $rating->id]) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Campo para calificación -->
                <div>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Calificación (1 a 5)</span>
                        <input type="number" id="rating" name="rating" value="{{ old('rating', $rating->rating) }}" min="1" max="5" required class="form-input mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0">
                    </label>
                </div>

                <!-- Campo para comentario -->
                <div>
                    <label class="block text-sm">
                        <span class="text-gray-700 dark:text-gray-400">Comentario</span>
                        <textarea id="comments" name="comments" rows="4" class="form-textarea mt-1 block w-full rounded-md bg-gray-100 border-transparent focus:border-gray-500 focus:bg-white focus:ring-0" required>{{ old('comments', $rating->comments) }}</textarea>
                    </label>
                </div>

                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:shadow-outline">Actualizar</button>
            </form>
        @else
            <p class="text-gray-700 dark:text-gray-400">No tienes permiso para editar esta calificación.</p>
        @endcan
    </div>
@endsection
