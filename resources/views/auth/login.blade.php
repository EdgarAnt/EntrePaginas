<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/style-register-login.css') }}">
  <link href="{{ asset('css/tailwind.output.css') }}" rel="stylesheet">
  <title>Inicio de sesión</title>
</head>
<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <div id="mssg-error" class="mt-4">
          @include('partials.form-errors')
        </div>
        <form method="POST" action="{{ route('login') }}" class="sign-in-form">
          @csrf
          <h2 class="title">Iniciar sesión</h2>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" id="email" name="email" value="{{ old('email') }}"/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Contraseña" name="password" id="password"/>
          </div>
          <button class="btn solid focus:outline-none">
            {{ __('Iniciar sesión') }}
          </button>
          <div class="form-bottom-text">
            <a class="forgot-password-link" href="{{ route('password.request') }}">
              {{ __('¿Olvidaste tu contraseña?') }}
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/app-register-login.js') }}"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('sign-in-btn').addEventListener('click', function() {
        document.getElementById('mssg-error').style.display = 'none';
      });

      document.getElementById('sign-up-btn').addEventListener('click', function() {
        document.getElementById('mssg-error').style.display = 'none';
      });
    });
  </script>
</body>
</html>