@extends('layouts.temp')

@section('media')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Entrepaginas</title>
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" />
    <!--Replace with your tailwind.css once created-->
    <link href="https://unpkg.com/@tailwindcss/custom-forms/dist/custom-forms.min.css" rel="stylesheet" />

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap");

        html {
            font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }

    </style>
</head>

<body class="leading-normal tracking-normal text-indigo-400 m-6 bg-cover bg-fixed"
    style="background-image: url('img/landPage.png');">
    <div class="h-full">

      <!--Nav-->
      <div class="w-full container mx-auto">
        <div class="w-full flex items-center justify-between">
          <a class="flex items-center text-indigo-400 no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="">
          </a>
          @if (Route::has('login'))
              <div class="hidden fixed top-2 right-8 px-6 py-4 sm:block">
                  @auth
                      <a href="{{ url('/content/main') }}" class="flex bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out">
                      Ingresar
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                      </svg>
                      </a>
                  @else
                    <a href="{{ route('login') }}" class="flex bg-gradient-to-r from-purple-800 to-green-500 hover:from-pink-500 hover:to-green-500 text-white font-bold py-2 px-4 rounded focus:ring transform transition hover:scale-105 duration-300 ease-in-out">
                      Iniciar sesion
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" fill="none" viewBox="0 0 20 20" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                      </svg>
                    </a>
                    
                  @endauth
              </div>
          @endif
          
        </div>
      </div>
      @if($contents->count())
      <div class="container">
        <div class="glide">
          <p class="text-white mt-4">Todo el contenido</p>
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides items-center text-center mt-4">
                @foreach ($contents as $content)
                <li class="glide__slide text-gray-700 dark:text-gray-400 max-h-1">
                    <a class="text-white mt-4" href="{{route('content.show', $content->id)}}">{{ $content->title }} <img style="height: 15rem;width:max-content;object-fit: cover;" src="{{ asset($content->image_path) }}" alt=""></a>
                </li>
                @endforeach
                </ul>
            </div>
            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left button-nav px-4" data-glide-dir="<">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                  </svg>
                </button>
                <button class="glide__arrow glide__arrow--right button-nav px-4" data-glide-dir=">">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                </button>
            </div>
        </div>
      @else
      <div class="container text-white mt-8">
        No hay elementos
      </div>
      @endif
  
        <!-- Categories carousel -->
        @foreach ($categories as $category)
          @if($category->contents->count())
            <div class="container">
              <div class="glide">
                <p class="text-white mt-4">{{ $category->name }}</p>
                  <div class="glide__track" data-glide-el="track">
                      <ul class="glide__slides items-center text-center mt-4">
                      @foreach ($category->contents as $content)
                      <li class="glide__slide text-gray-700 dark:text-gray-400">
                          <a class="text-white" href="{{route('content.show', $content->id)}}">{{ $content->name }} <img style="height: 15rem;width:max-content;object-fit: cover;" src="{{ asset($content->image_path) }}" alt=""></a>
                      </li>
                      @endforeach
                      </ul>
                  </div>
                  <div class="glide__arrows" data-glide-el="controls">
                      <button class="glide__arrow glide__arrow--left button-nav px-4" data-glide-dir="<">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd" />
                        </svg>
                      </button>
                      <button class="glide__arrow glide__arrow--right button-nav px-4" data-glide-dir=">">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1 1 0 00-1.414 1.414L10.586 9H7a1 1 0 100 2h3.586l-1.293 1.293a1 1 0 101.414 1.414l3-3a1 1 0 000-1.414z" clip-rule="evenodd" />
                      </svg>
                      </button>
                  </div>
              </div>
            </div>
            @endif
        @endforeach
  
      </div> 
  
      <script src="https://cdn.jsdelivr.net/npm/@glidejs/glide"></script>
      <script>
          const config = {
              type: 'carousel',
              perView: 3,
              breakpoints: {
                  1024: {
                      perView: 2
                  },
                  600: {
                      perView: 1
                  }
              }
          }
          // new Glide('.glide', config).mount()
  
          var sliders = document.querySelectorAll('.glide');
  
          console.log(sliders);
  
          for (var i = 0; i < sliders.length; i++) {
            var glide = new Glide(sliders[i], {
              gap: 15,
              perView: 3,
              breakpoints: {
                  1450: {
                      perView: 2
                  },
                  900: {
                      perView: 1
                  }
              }
            });
            glide.mount();
          }
      </script>

     

</html>
@endsection