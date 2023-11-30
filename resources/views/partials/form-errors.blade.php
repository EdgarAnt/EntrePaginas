@if ($errors->any())
    <div class="p-4 text-white bg-purple-600 rounded-lg w-2/4" id="error-mssg">
        <h4 class="mb-4 font-semibold">
            Verifique los campos del formulario
        </h4>
        <p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </p>
    </div>
@endif
{{-- Mensajes de éxito --}}
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Mensajes de error --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Mensajes de información --}}
@if(session('message'))
    <div class="alert alert-info">
        {{ session('info') }}
    </div>
@endif

{{-- Mensajes de alerta --}}
@if(session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif

{{-- Errores de validación --}}
