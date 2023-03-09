<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Iniciar sesión - Sistema de alerta comunitaria General Alvear</title>
    <style>
        main {
            background-image: url(src/login_background.svg);
            background-position: center;
            background-size: cover;
        }
    </style>
    @vite('resources/js/login.js')
</head>

<body class="antialiased">
    <main class="w-screen h-screen flex items-center justify-center">
        <div>
            <div class="flex justify-center p-2 rounded-md bg-white/60 mb-2">
                <img class="w-24 mx-1" src="{{asset('src/logo.png')}}" />
                <img class="w-24 mx-1" src="{{asset('src/general-alvear.png')}}" />
            </div>
            <h1 class="text-3xl text-white mb-5 text-center">Iniciar sesión</h1>
            <form autocomplete="off" class="w-72" method="POST" action="login">
                @csrf
                <div class="bg-white bg-opacity-40 rounded-md relative">
                    <i class="bi bi-person text-white absolute top-3 left-3"></i>
                    <input class="bg-transparent appearance-none text-white placeholder-white focus-visible:outline-none focus:outline-none pl-9 py-3 w-full rounded-md" name="username" placeholder="Nombre de usuario" type="text" />
                </div>
                <div class="bg-white bg-opacity-40 rounded-md mt-4 relative">
                    <i class="bi bi-key text-white absolute top-3 left-3"></i>
                    <input class="fill-transparent bg-transparent appearance-none text-white placeholder-white focus-visible:outline-none focus:outline-none pl-9 py-3 w-full rounded-md" name="password" placeholder="Contraseña" type="password" />
                </div>
                <div class="mt-4">
                    <input type="checkbox" name="remember" class="mr-2" />
                    <label class="text-white">Recordar credenciales</label>
                </div>
                <div class="toast align-items-center text-bg-danger invalid-login
                    @if (count($errors) > 0) show @endif" role="alert" aria-live="assertive" aria-atomic="true">
                    <div style="display: flex;">
                        <div class="toast-body">
                            Usuario o contraseña incorrectos
                        </div>
                    </div>
                </div>
                <p class="text-center mt-10">
                    <button type="submit" class="bg-white bg-opacity-40 py-2 rounded-full text-white px-10">Iniciar sesión</button>
                </p>
                <p class="text-center mt-5">
                    <a class="text-white text-center underline" href="#">He olvidado mi contraseña</a>
                </p>

            </form>
        </div>
    </main>

</body>

</html>