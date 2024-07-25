<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Index</title>
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body>
    <section>
        @if(isset($mensaje))
            <div style="width: 100%;" class="alertContaier">
                <div class="alert alert-danger moveAlert">
                    {{ $mensaje }}
                </div>
            </div>
        @endif

        <div class="formContainer">
            <h1 class="text-center">Login</h1>

            <form method="POST" class="login-form" action="{{ route('login.post') }}">
                @csrf
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario</label>
                    <input id="usuario" name="usuario" type="text" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Clave</label>
                    <input id="clave" name="clave" type="password" class="form-control">
                </div>
                <button type="submit" id="loginBtn" class="btn btn-primary btn-lg btn-block">Iniciar Sesión</button>
            </form>
        </div>
    </section>
</body>
</html>
