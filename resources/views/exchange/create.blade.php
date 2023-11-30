@extends('layouts.temp')

@section('media')
<div class="container my-4">
    <h2 class="my-6 text-2xl font-semibold text-gray-800 dark:text-white text-center">Ofrecer un Libro para Intercambio</h2>
    <form action="{{ route('exchanges.store') }}" method="POST" enctype="multipart/form-data" class="mt-4 bg-white dark:bg-gray-800 rounded-lg shadow-md px-4 py-3 mb-8">
        @csrf
        @include('partials.form-errors') 


        <div class="mb-4">
            <label for="content_id" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Selecciona un Libro</label>
            <select class="form-input w-full" id="content_id" name="content_id" required>
                @foreach ($contents as $content)
                    <option value="{{ $content->id }}">{{ $content->title }}</option>
                @endforeach
            </select>
        </div>
        

        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Título del Libro</label>
            <input type="text" class="form-input w-full" id="title" name="title" placeholder="Introduce el título del libro" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Descripción</label>
            <textarea class="form-textarea w-full" id="description" name="description" placeholder="Describe el libro" required></textarea>
        </div>

        <div class="mb-4">
            <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Autor</label>
            <input type="text" class="form-input w-full" id="author" name="author" placeholder="Autor del libro">
        </div>

        <div class="mb-4">
            <label for="publisher" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Editorial</label>
            <input type="text" class="form-input w-full" id="publisher" name="publisher" placeholder="Editorial del libro">
        </div>

        <div class="mb-4">
            <label for="year" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Año de Publicación</label>
            <input type="text" class="form-input w-full" id="year" name="year" placeholder="Año de publicación">
        </div>

        <div class="mb-4">
            <label for="pages" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Número de Páginas</label>
            <input type="number" class="form-input w-full" id="pages" name="pages" placeholder="Número de páginas">
        </div>

        <div class="mb-4">
            <label for="isbn" class="block text-sm font-medium text-gray-700 dark:text-gray-400">ISBN</label>
            <input type="text" class="form-input w-full" id="isbn" name="isbn" placeholder="ISBN del libro">
        </div>

        <div class="mb-4">
            <label for="condition" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Condición del Libro</label>
            <select class="form-input w-full" id="condition" name="condition" required>
                <option value="">Selecciona una condición</option>
                <option value="nuevo">Nuevo</option>
                <option value="usado">Usado</option>
                <option value="usado_en_buen_estado">Usado en Buen Estado</option>
                <option value="usado_con_marcas_de_uso">Usado con Marcas de Uso</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="offer_message" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Mensaje para la Oferta</label>
            <textarea class="form-textarea w-full" id="offer_message" name="offer_message" placeholder="Introduce un mensaje para la oferta" required></textarea>
        </div>

        <div class="mb-4">
            <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Imagen del Libro</label>
            <input type="file" class="form-input w-full" id="image" name="image_path">
        </div>

        <div class="flex justify-center mt-6">
            <button type="submit" class="button-nav">
                Enviar Oferta
            </button>
        </div>
    </form>
</div>
@endsection
