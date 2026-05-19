<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Token de dispositivo</title>
</head>
<body>
    <main>
        <h1>Token de dispositivo</h1>

        @if (session('registration_url'))
            <section>
                <h2>Enlace generado</h2>
                <p>Abre este enlace una sola vez desde el dispositivo que quieres autorizar:</p>
                <p>
                    <a href="{{ session('registration_url') }}">{{ session('registration_url') }}</a>
                </p>
            </section>
        @endif

        @if ($errors->any())
            <section>
                <h2>Revisa los datos</h2>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </section>
        @endif

        <form method="POST" action="{{ route('temporary-device-token.store') }}">
            @csrf

            <div>
                <label for="soporte_usuario">Usuario SOPORTE</label>
                <input id="soporte_usuario" name="soporte_usuario" type="text" value="{{ old('soporte_usuario') }}" required autocomplete="username">
            </div>

            <div>
                <label for="soporte_password">Contrasena SOPORTE</label>
                <input id="soporte_password" name="soporte_password" type="password" required autocomplete="current-password">
            </div>

            <div>
                <label for="nombre">Nombre del dispositivo</label>
                <input id="nombre" name="nombre" type="text" value="{{ old('nombre', 'Mi equipo') }}" maxlength="150" required>
            </div>

            <div>
                <label for="usuario">Usuario asociado</label>
                <input id="usuario" name="usuario" type="text" value="{{ old('usuario') }}">
            </div>

            <button type="submit">Generar enlace</button>
        </form>
    </main>
</body>
</html>
