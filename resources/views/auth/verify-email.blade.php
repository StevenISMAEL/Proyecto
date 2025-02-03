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
            <h2>{{ __('Verificar Correo Electrónico') }}</h2>
            <p>
                {{ __('Gracias por registrarte. Antes de empezar, verifica tu correo electrónico haciendo clic en el enlace que te hemos enviado. Si no recibiste el correo, con gusto te enviaremos otro.') }}
            </p>

            <!-- Mensaje de confirmación -->
            @if (session('status') == 'verification-link-sent')
                <p class="status-message">
                    {{ __('Un nuevo enlace de verificación se ha enviado a tu dirección de correo electrónico.') }}
                </p>
            @endif

            <!-- Botón para reenviar el enlace -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-auth">{{ __('Reenviar Correo') }}</button>
            </form>

            <!-- Botón para cerrar sesión -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary">{{ __('Cerrar Sesión') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
