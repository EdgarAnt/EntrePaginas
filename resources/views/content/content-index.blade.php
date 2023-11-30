@extends('layouts.temp')

@section('media')

<h2 class="my-6 text-2xl font-semibold text-white dark:text-gray-200">Listado de Libros</h2>

<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4 mt-8">
    <!-- Botón para agregar nuevo libro -->
    <div>
        <a class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple dark:bg-orange-500"
            href="{{ route('content.create') }}">
            Agregar libro
        </a>
    </div>

    <!-- Mensaje con información del estatus del contenido -->
    <div>
        @include('partials.message-status')
    </div>

</div>

<div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs mt-6">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3">Título</th>
                    <th class="px-4 py-3">Autor</th>
                    <th class="px-4 py-3">Editorial</th>
                    <th class="px-4 py-3">Año</th>
                    <th class="px-4 py-3">ISBN</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                @foreach ($contents as $content)
          
                <tr class="text-gray-700 dark:text-gray-400">
                    <!-- TÍTULO -->
                    <td class="px-4 py-3 text-sm">
                        {{ $content->title }}
                    </td>

                    <!-- AUTOR -->
                    <td class="px-4 py-3 text-sm">
                        {{ $content->author }}
                    </td>

                    <!-- EDITORIAL -->
                    <td class="px-4 py-3 text-sm">
                        {{ $content->publisher }}
                    </td>

                    <!-- AÑO -->
                    <td class="px-4 py-3 text-sm">
                        {{ $content->year }}
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <p>{{ $content->isbn }}</p>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ $content->price}}
                    </td>


                    <!-- ACCIONES -->
                    <td class="px-4 py-3">
                        <a class="flex a-table dark:hover:text-purple-600 dark:text-gray-400" href="{{route('content.show', $content->id)}}">Ver
                            <!-- SVG ICON -->
                        </a>
                        <!-- Aquí puedes agregar más botones de acción si es necesario -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
