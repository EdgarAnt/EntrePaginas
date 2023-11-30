<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ asset('css/style-register-login.css') }}">
  <link href="{{ asset('css/tailwind.output.css') }}" rel="stylesheet">
  <title>Registro</title>
</head>
<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <div id="mssg-error" class="mt-4">
          @include('partials.form-errors')
        </div>
        <form method="POST" action="{{ route('register') }}" class="sign-in-form">
          @csrf
          <h2 class="title">Registro</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="Nombre de usuario" name="name" id="name" value="{{ old('name') }}"/>
          </div>
          <div class="input-field">
            <i class="fas fa-envelope"></i>
            <input type="email" placeholder="Email" name="email" id="email" value="{{ old('email') }}"/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Contraseña" name="password" id="password"/>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Confirmar contraseña" name="password_confirmation" id="password_confirmation"/>
          </div>
          <button class="btn solid focus:outline-none">{{ __('Registrarse') }}</button>
          <div class="form-bottom-text">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}">Iniciar sesión</a></p>
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