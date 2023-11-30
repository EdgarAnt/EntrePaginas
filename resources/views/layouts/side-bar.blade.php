<aside class="z-20 hidden w-40 sm:w-30 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ url('/content/main') }}">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-400 via-green-500 to-purple-500">Entrepaginas</span>
        </a>        <div class="px-6 py-4">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="query" placeholder="Buscar libros..." required class="block w-full pl-4 pr-10 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-full dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:border-purple-400" />
                <button type="submit" class="mt-2 w-full text-sm font-semibold text-white transition-colors duration-150 bg-purple-600 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Buscar
                </button>   
            </form>
        </div>
        


        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('content.index') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="ml-4">Publicar un libro</span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('category.index') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <span class="ml-4">Géneros</span>
                </a>
            </li>

            <!-- Ícono de carrito de compras -->
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('cart.show') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 3h18l-2 10H5L3 3z"></path>
                        <circle cx="9" cy="21" r="2"></circle>
                        <circle cx="20" cy="21" r="2"></circle>
                    </svg>
                    <span class="ml-4">Carrito</span>
                </a>
                
            </li>
            <li class="relative px-6 py-3">
                        <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
            href="{{ route('exchange.index') }}">
            <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                    stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                <!-- Icono genérico de intercambio, reemplaza con un icono adecuado -->
                <path d="M3 3h18l-2 10H5L3 3z"></path>
                <path d="M12 17l-4 4 4 4m0-8l4 4-4 4"></path>
            </svg>
            <span class="ml-4">Intercambios</span>
            </a>
         </li>
        </ul>
    </div>
  
</aside>


<!-- Mobile sidebar -->
<!-- Backdrop -->

<div x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"></div>
<aside class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
    x-show="isSideMenuOpen" x-transition:enter="transition ease-in-out duration-150"
    x-transition:enter-start="opacity-0 transform -translate-x-20" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in-out duration-150" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 transform -translate-x-20" @click.away="closeSideMenu"
    @keydown.escape="closeSideMenu">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="ml-6 text-lg font-bold text-gray-800 dark:text-gray-200" href="{{ url('/content/main') }}">
            <span class="bg-clip-text text-transparent bg-gradient-to-r from-red-400 via-green-500 to-purple-500">EntrePáginas</span>
        </a>
        
        <div class="px-6 py-4">
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="query" placeholder="Buscar libros..." required class="block w-full pl-4 pr-10 py-2 text-sm text-gray-600 bg-white border border-gray-300 rounded-full dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 focus:border-purple-400" />
                <button type="submit" class="mt-2 w-full text-sm font-semibold text-white transition-colors duration-150 bg-purple-600 py-2 rounded-md hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Buscar
                </button>
            </form>
        </div>
        
        <ul class="mt-6">
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('content.index') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="ml-4">Publicar un libro</span>
                </a>
            </li>

            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('category.index') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                        </path>
                    </svg>
                    <span class="ml-4">Géneros</span>
                </a>
            </li>
            <li class="relative px-6 py-3">
                <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
                    href="{{ route('cart.show') }}">
                    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M3 3h18l-2 10H5L3 3z"></path>
                        <circle cx="9" cy="21" r="2"></circle>
                        <circle cx="20" cy="21" r="2"></circle>
                    </svg>
                    <span class="ml-4">Carrito</span>
                </a>
                    <a class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
    href="{{ route('exchange.index') }}">
    <svg class="w-5 h-5" aria-hidden="true" fill="none" stroke-linecap="round" stroke-linejoin="round"
            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
        <!-- Icono genérico de intercambio, reemplaza con un icono adecuado -->
        <path d="M3 3h18l-2 10H5L3 3z"></path>
        <path d="M12 17l-4 4 4 4m0-8l4 4-4 4"></path>
    </svg>
    <span class="ml-4">Intercambios</span>
    </a>

            </li>
        </ul>                
    </div>
</aside>

