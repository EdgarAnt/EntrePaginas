<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href= "{{ asset('css/style-register-login.css') }}" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>Recuperar contraseña</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <div class="m-8">
            @include('partials.form-errors')
          </div>
				<form method="POST" action="{{ route('password.email') }}" class="sign-in-form">
            @csrf
            <h2 class="title">Restablecer contraseña</h2>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" id="email" name="email" :value="old('email')"/>
            </div>
            <button class="btn solid focus:outline-none m-2 w-1/4">
                {{ __('Email Password Reset Link') }}
            </button>
						
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Recordaste la contraseña ?</h3>
            <p class="mb-4">
              Super! Entonces por que no iniciamos sesion y disfrutamos
							de todo el amplio catalogo que Memflix tiene para ti ?
            </p>
            <a href="{{ route('login') }}" class="btn transparent" style="color:white;text-decoration:none;padding:0.5rem;">Iniciar sesion</a>
          </div>
          <img src="img/forgot-pass.svg" class="image" alt="" />
        </div>
      </div>
    </div>

    <script src="{{ asset('js/app-register-login.js') }}"></script>
  </body>
</html>

{{-- <x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-jet-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="block">
                <x-jet-label for="email" value="{{ __('Email') }}" />
                <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-jet-button>
                    {{ __('Email Password Reset Link') }}
                </x-jet-button>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout> --}}