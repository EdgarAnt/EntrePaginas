@extends('layouts.temp')

@section('media')

@if(isset($content))
    <h2 class="my-6 text-2xl font-semibold text-white dark:text-gray-200">Editar Contenido</h2>
@else 
    <h2 class="my-6 text-2xl font-semibold text-white dark:text-gray-200">Agregar Contenido</h2>
@endif

@if(isset($content))
<div>
    <a class="button-nav" href="{{ route('content.show', $content->id) }}">Regresar</a>
</div>
@else
<div>
    <a class="button-nav" href="{{ route('content.index') }}">Regresar al listado de contenido</a>
</div>
@endif

<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 mt-6">
    @include('partials.form-errors') 
    @if(isset($content))
        {{-- Edición de contenido --}}
        <form action="{{route('content.update', $content)}}" method="POST">
            @method('PATCH')
    @else
        {{-- Creación de contenido --}}
        <form action="{{route('content.store')}}" method="POST" enctype="multipart/form-data">
    @endif
    @csrf
    
    <br>
    <label for="title" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Título</span>
        <input type="text" class="form-input" placeholder="Escribe el título del contenido..." name="title" id="title" value="{{ old('title') ?? $content->title ?? ''}}" />
    </label>
    <br>
    <label for="description" class="block mt-4 text-sm">
        <span class="text-gray-700 dark:text-gray-400">Descripción</span>
        <textarea class="form-textarea" rows="3" placeholder="Escribe la descripción del contenido..." name="description" id="description">{{ old('description') ?? $content->description ?? ''}}</textarea>
    </label>
    <br>
    <label for="author" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Autor</span>
        <input type="text" class="form-input" placeholder="Autor del contenido..." name="author" id="author" value="{{ old('author') ?? $content->author ?? ''}}" />
    </label>
    <br>
    <label for="publisher" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Editorial</span>
        <input type="text" class="form-input" placeholder="Editorial del contenido..." name="publisher" id="publisher" value="{{ old('publisher') ?? $content->publisher ?? ''}}" />
    </label>
    <br>
    <label for="year" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Año</span>
        <input type="number" class="form-input" name="year" id="year" value="{{ old('year') ?? $content->year ?? ''}}" />
    </label>
    <br>
    <label for="pages" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Número de páginas</span>
        <input type="number" class="form-input" name="pages" id="pages" value="{{ old('pages') ?? $content->pages ?? ''}}" />
    </label>
    <br>
    <label for="isbn" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">ISBN</span>
        <input type="text" class="form-input" name="isbn" id="isbn" value="{{ old('isbn') ?? $content->isbn ?? ''}}" />
    </label>
    <br>
    <label for="price" class="block text-sm mt-4">
        <span class="text-gray-700 dark:text-gray-400">Precio</span>
        <input type="number" step="0.01" class="form-input" placeholder="Precio del libro..." name="price" id="price" value="{{ old('price') ?? $content->price ?? '' }}" />
    </label>

    <br>
    @if(!isset($content))
    <label for="image_temp" class="block text-sm">
        <span class="text-gray-700 dark:text-gray-400">Seleccionar imagen</span>
        <input type="file" class="form-input" name="image_temp" id="image_temp"/>
    </label>
    @endif

   

    <div class="py-4">
        <button type="submit" class="button-nav">
            @if(isset($content))
                <span>Guardar cambios</span>
            @else
                <span>Agregar contenido</span>
            @endif
        </button>
    </div>
    </form>
</div>
@endsection