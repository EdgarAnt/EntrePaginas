@extends('layouts.temp')
@section('media')

<h2 class="my-6 text-2xl font-semibold text-white dark:text-gray-200">Listado de Géneros</h2>

@include('partials.form-errors')
@if(isset($category))
@can('update', \App\Models\Category::class)
<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 mt-6">
    {{-- Edición de contenido --}}
    <form action="{{route('category.update', $category)}}" method="POST">
        @method('PATCH') {{--Para cumplir con el estandar--}}
        @csrf
        <label for="name" class="dark:text-white" >Editar género:</label>
        <input type="text" name="name" id="name" value="{{$category->name ?? ''}}" class="justify-between px-2 py-1 text-sm font-medium leading-5 text-black dark:text-white transition-colors duration-150 bg-gray-100 border border-transparent rounded-lg active:bg-purple-600 hover:bg-gray-100 focus:outline-none focus:shadow-outline-purple dark:bg-gray-700">
        <div class="py-4">
            <button type="submit"
                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <span>Guardar cambio</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
            </button>
        </div>
    </form>
</div>
@endcan
@else
@can('create', \App\Models\Category::class)
<div class="px-4 py-3 mb-8 bg-white rounded-lg shadow-md dark:bg-gray-800 mt-6 grid gap-6 grid-cols-2">
    {{-- Creación de contenido --}}    
    <form action="{{route('category.store')}}" method="POST">
        @csrf
        <label for="name" class="dark:text-white">Agregar género:</label>
        <input type="text" name="name" id="name" value="{{ old('name') ?? $category->name ?? ''}}" class="justify-between px-2 py-1 text-sm font-medium leading-5 text-black transition-colors duration-150 bg-gray-100 border border-transparent rounded-lg active:bg-purple-600 hover:bg-gray-100 focus:outline-none focus:shadow-outline-purple dark:bg-gray-700">
        <div class="py-4">
            <button type="submit"
                class="flex items-center justify-between px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple dark:bg-orange-500">
                <span>Guardar cambio</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
            </button>
            
        </div>
    </form>
@endcan
    <!-- Mensaje con informacion del estatus del contenido -->
    <div>
        @include('partials.message-status')
    </div>

</div>

<div class="flex flex-col-4 flex-wrap">
    @foreach ($categories as $category)
    <div class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800 mr-4 mb-4 w-full"> {{-- w-full es el que los hace largos --}}
        <div class="p-3 mr-4 text-purple-600 bg-gray-50 rounded-full dark:text-orange-100 dark:bg-orange-500">
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
        <div>
            <a href="{{route('category.edit', $category)}}"
                class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-blue-500 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                aria-label="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </a>
        </div>
        <div>
            <form action="{{route('category.destroy', $category)}}" method="POST">
                @csrf
                @method('DELETE')                
                    <button type="submit"
                    class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-red-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray">                        
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@endif

@endsection
