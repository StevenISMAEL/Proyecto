<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
</head>

<body>
    <div class="container-auth">
        <div class="card-auth">
            <img src="{{ asset('images/logotipo.png') }}" alt="Logotipo">
            <h2>{{ __('Confirmar Contraseña') }}</h2>
            <p>{{ __('Esta es un área segura de la aplicación. Por favor confirma tu contraseña antes de continuar.') }}</p>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" name="password" class="form-control" required autocomplete="current-password">
                </div>
                <button type="submit" class="btn-auth">{{ __('Confirmar') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
