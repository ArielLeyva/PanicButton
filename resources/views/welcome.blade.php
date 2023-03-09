<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Sistema de alerta comunitaria - General Alvear</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
</head>

<body class="antialiased">
    <div id="app" class="h-screen w-screen relative"></div>
    <div id="modals"></div>
    <div id="alerts" class="fixed top-10 right-5"></div>
    @vite('resources/js/app.js')
</body>

</html>