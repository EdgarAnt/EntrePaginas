@extends('layouts.temp')

@section('media')

<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 mt-8">
    <!-- Botón para regresar al listado de libros -->
    <div>
        <a class="button-nav" href="{{ route('content.index') }}">
            Regresar al listado de libros
            <!-- SVG icon for back arrow here -->
        </a>
    </div>

    <!-- Solo muestra los botones de editar y eliminar si el usuario autenticado es el creador del contenido -->
    @can('update', $content)
        <div>
            <a class="button-nav" href="{{ route('content.edit', $content) }}">
                Editar libro
                <!-- SVG icon for edit here -->
            </a>
        </div>
        <div>
            <form action="{{ route('content.destroy', $content) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="button-nav-delete">
                    Eliminar libro
                    <!-- SVG icon for delete here -->
                </button>
            </form>
        </div>
    @endcan

    <!-- Botón para añadir al carrito, visible para todos los usuarios autenticados -->
    @if(auth()->check() && !auth()->user()->contents->contains($content->id))
    <div>
        <form action="{{ route('cart.add', $content->id) }}" method="POST">
            @csrf
            <button type="submit" class="button-nav">
                Añadir al Carrito
                <!-- SVG icon for cart here -->
            </button>
        </form>
    </div>
    <div>
        <a class="button-nav" href="{{ route('exchange.create', $content->id) }}">
            Solicitar Intercambio
            <!-- SVG icon for exchange here -->
        </a>
    </div>
@endif

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">¡Hecho!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

    <div>
        @include('partials.message-status')
    </div>
</div>


<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4">
    <div class="grid gap-6 mb-8 md:grid-rows-2 xl:grid-rows-1 md:grid-cols-2 xl:grid-cols-4">
        <div>
            @if($content->image_path)
                <img src="{{ asset($content->image_path) }}" alt="Portada del libro">
            @endif
        </div>
        <div class="flex items-center p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Título
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $content->title }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Autor
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $content->author }}
                </p>
            </div>
        </div>
        <div class="flex items-center p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    Año de Publicación
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $content->year }}
                </p>
            </div>
        </div>
    </div>
    <div class="p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
        <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
            Descripción
        </p>
        <p class="text-gray-700 dark:text-gray-200">
            {{ $content->description }}
        </p>
    </div>
   
        <div class="p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                ISBN
            </p>
            <p class="text-gray-700 dark:text-gray-200">
                {{ $content->isbn }}
            </p>
        </div>

        <div class="block text-sm mt-4">
            <span class="text-gray-700 dark:text-gray-400">Precio:</span>
            <p class="mt-1 text-gray-700 dark:text-gray-200">
                ${{ number_format($content->price, 2) }} MXN
            </p>
        </div>
        
        
        <div class="p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Publicado por:</h3>
            @if($users->isEmpty())
                <p class="text-gray-700 dark:text-gray-200">No hay usuarios asociados.</p>
            @else
                <ul>
                    @foreach ($users as $user)
                        <li class="text-gray-700 dark:text-gray-200">{{ $user->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-200">Correo del vendedor</h3>
            @if($users->isEmpty())
                <p class="text-gray-700 dark:text-gray-200">No corros asociados</p>
            @else
                <ul>
                    @foreach ($users as $user)
                        <li class="text-gray-700 dark:text-gray-200">{{ $user->email }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
  
</div>  
 
<div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4">
    <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Géneros</h2>
     <!-- Si el usuario es admin, puede agregar géneros al contenido -->
    
         <form action="{{ route('content.add-category', $content->id) }}" method="POST">
        @csrf
        <label class="block mt-4 text-sm">
            <span class="text-gray-700 dark:text-gray-400">
                Seleccione un género
            </span>
            <select
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray mb-4"
                name="category_id">
                @foreach($userCategories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </label>

        <button type="submit"
            class="button-nav">
            <span>Agregar Género</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
            </svg>
        </button>
    </form>
  
    <div class="flex flex-col-4 flex-wrap">
        @foreach ($contentCategories as $category)
        <div class="flex items-center p-4 bg-gray-100 rounded-lg shadow-xs dark:bg-gray-800 mr-4 mb-4 mt-4">
            <div class="p-3 mr-4 text-purple-600 bg-transparent rounded-full dark:text-orange-100 dark:bg-orange-500">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {{ $category->name }}
                </p>
            </div>
            @if(auth()->user()->id == $category->user_id)
            <div>
                <form action="{{ route('content.delete-category', $category->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="category_id" id="category_id" value="{{ $category->id }}">
                    <button type="submit" class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        @endif
                    
        </div>
        @endforeach
    </div>
</div>


    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Calificaciones y Comentarios</h2>
        
        @forelse ($ratings as $rating)
            <div class="border-b border-gray-200 mb-4">
                <p class="text-gray-700 dark:text-gray-200"><strong>Calificación:</strong> {{ $rating->rating }} / 5</p>
                @if ($rating->comments)
                    <p class="text-gray-700 dark:text-gray-200"><strong>Comentario:</strong> {{ $rating->comments }}</p>
                @else
                    <p class="text-gray-700 dark:text-gray-200">Sin comentario.</p>
                @endif
                <p class="text-gray-600 dark:text-gray-400">Por: {{ $rating->user->name ?? 'Usuario Anónimo' }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $rating->created_at->format('d/m/Y') }}</p>
                @can('update', $rating)
                    <a class="button-nav" href="{{ route('content.ratings.edit', ['content' => $content->id, 'rating' => $rating->id]) }}">Editar</a>
                @endcan
                @can('delete', $rating)
                    <form action="{{ route('content.ratings.destroy', ['content' => $content->id, 'rating' => $rating->id]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="button-nav-delete">Eliminar</button>
                    </form>
                @endcan
            </div>
        @empty
            <p class="text-gray-700 dark:text-gray-200">No hay calificaciones ni comentarios aún.</p>
        @endforelse
    </div>

    {{-- ...muestra de calificaciones y comentarios existentes... --}}
    <style>
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            text-align: left;
        }
        .rating > input {
            display: none;
        }
        .rating > label {
            display: inline-block;
            position: relative;
            width: 1.1em;
            cursor: pointer;
            color: #ccc;
        }
        .rating > label:hover,
        .rating > label:hover ~ label,
        .rating > input:checked ~ label {
            color: orange;
        }
    </style>

    @auth
    <div class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mb-4">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">Calificar y Comentar</h2>
        
        <form action="{{ route('content.rate', $content->id) }}" method="POST">
            @csrf
            {{-- Formulario de calificación --}}
            <div class="rating">
                @for ($i = 5; $i >= 1; $i--)
                <!-- Se utiliza un input tipo radio para cada estrella -->
                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                <label for="star{{ $i }}">★</label>
                @endfor
            </div>
            {{-- Formulario de comentario --}}
            <div class="mt-4">
                <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Comentario:</span>
                    <textarea name="comments" rows="4" class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-textarea focus:border-purple-400 focus:outline-none focus:shadow-outline-purple" placeholder="Escribe tu comentario aquí..."></textarea>
                </label>
            </div>
            <div class="mt-4">
                <button type="submit" class="button-nav">
                    Enviar Calificación y Comentario
                </button>
            </div>
        </form>
    </div>
@endauth
@endsection
