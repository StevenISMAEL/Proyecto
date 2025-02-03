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
            <h2>{{ __('Restablecer Contraseña') }}</h2>
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token de Restablecimiento -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Dirección de Correo -->
                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                </div>

                <!-- Contraseña Nueva -->
                <div class="form-group">
                    <label for="password">{{ __('Nueva Contraseña') }}</label>
                    <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
                </div>

                <!-- Confirmar Contraseña -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                    <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- Botón para Restablecer Contraseña -->
                <button type="submit" class="btn-auth">{{ __('Restablecer Contraseña') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
