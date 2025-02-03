<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/auth-styles.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #56ab2f, #a8e063);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container-auth {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            padding: 30px;
        }

        .card-auth img {
            max-width: 180px;
            margin: 0 auto 20px;
            display: block;
        }

        .card-auth h2 {
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 20px;
            color: #333;
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #56ab2f;
            outline: none;
            box-shadow: 0 0 5px rgba(86, 171, 47, 0.5);
        }

        .btn-auth {
            width: 100%;
            padding: 14px;
            font-size: 16px;
            font-weight: bold;
            background: #56ab2f;
            color: #fff;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-auth:hover {
            background: #4a9e2a;
        }

        .form-check {
            display: flex;
            align-items: center; /* Alineación vertical perfecta */
            gap: 8px; /* Espacio entre el checkbox y el texto */
        }

        .form-check-input {
            margin: 0; /* Elimina márgenes innecesarios */
            width: 18px;
            height: 18px; /* Tamaño consistente del checkbox */
        }

        .form-check-label {
            font-size: 14px;
            color: #555;
        }

        .text-center {
            margin-top: 20px;
        }

        .text-center a {
            color: #56ab2f;
            text-decoration: none;
            font-weight: bold;
        }

        .text-center a:hover {
            color: #4a9e2a;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container-auth">
        <div class="card-auth">
            <img src="{{ asset('images/logotipo.png') }}" alt="Logotipo">
            <h2>{{ __('Iniciar Sesión') }}</h2>
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Campo de correo electrónico -->
                <div class="form-group">
                    <label for="email">{{ __('Correo Electrónico') }}</label>
                    <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Campo de contraseña -->
                <div class="form-group">
                    <label for="password">{{ __('Contraseña') }}</label>
                    <input id="password" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span class="invalid-feedback" role="alert" style="color: red;">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <!-- Recordarme -->
                <div class="form-group form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">{{ __('Recordarme') }}</label>
                </div>

                <!-- Botón de inicio de sesión -->
                <div class="form-group">
                    <button type="submit" class="btn-auth">{{ __('Iniciar Sesión') }}</button>
                </div>

                <!-- Enlace de recuperar contraseña -->
                <div class="text-center">
                    <a href="{{ route('password.request') }}">{{ __('¿Olvidaste tu contraseña?') }}</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
