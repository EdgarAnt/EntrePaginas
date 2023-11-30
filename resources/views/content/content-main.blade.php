@extends('layouts.temp')

@section('media')
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
@endsection

