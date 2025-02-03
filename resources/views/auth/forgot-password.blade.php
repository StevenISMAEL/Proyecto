<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
    <style>
        .btn-secondary {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            font-weight: bold;
            background: #a9a9a9;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s ease;
        }

        .btn-secondary:hover {
            background: #8e8e8e;
        }

        .status-message {
            margin-top: 15px;
            font-size: 14px;
            color: #4caf50; /* Verde para éxito */
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container-auth">
        <div class="card-auth">
            <img src="{{ asset('images/logotipo.png') }}" alt="Logotipo">
            <h2>{{ __('Recuperar Contraseña') }}</h2>
            <p>{{ __('¿Olvidaste tu contraseña? No hay problema. Déjanos tu correo electrónico y te enviaremos un enlace para restablecerla.') }}</p>

            <!-- Mensaje de confirmación -->
            @if (session('status'))
                <p class="status-message">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" name="email" class="form-control" required>
                </div>
                <button type="submit" class="btn-auth">{{ __('Enviar Enlace de Recuperación') }}</button>
            </form>

            <!-- Botón para volver al inicio de sesión -->
            <form action="{{ route('login') }}" method="GET">
                <button type="submit" class="btn-secondary">{{ __('Volver al Login') }}</button>
            </form>
        </div>
    </div>
</body>

</html>
