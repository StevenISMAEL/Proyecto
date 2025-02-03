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
            <h2>{{ __('Registrar Cuenta') }}</h2>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">{{ __('Nombre') }}</label>
                    <input id="name" type="text" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirmar Contraseña') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" required>
                </div>
                <button type="submit" class="btn-auth">{{ __('Registrar') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
