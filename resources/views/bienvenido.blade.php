<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <link rel="stylesheet" href="{{asset('css/bienvenido.css')}}">
    <script src="{{asset('js/icon_animation.js')}}" defer></script>
    <title>Mi sshop</title>
</head>
<body>
<main>

    <h1 class="mainHeading">¡Maneja tus ventas de manera fácil ahora!</h1>

    <div class="message">
        Si ya tienes una cuenta, <a href="/login">inicia sesión</a> ahora. Si no, puedes <a href="/register">crearte</a> una cuenta gratis ahora.
    </div>


    <div class="mensajes">
        <span class="mssge">Inventario</span>
        <span class="mssge">Estadísticas</span>
        <span class="mssge">...y más!</span>
    </div>
    <div class="animation">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 21v-13l9 -4l9 4v13" />
                <path d="M13 13h4v8h-10v-6h6" />
                <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
            </svg>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-chart-histogram"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M3 3v18h18" />
                <path d="M20 18v3" />
                <path d="M16 16v5" />
                <path d="M12 13v8" />
                <path d="M8 16v5" />
                <path d="M3 11c6 0 5 -5 9 -5s3 5 9 5" />
            </svg>
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-pig-money"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M15 11v.01" />
                <path d="M5.173 8.378a3 3 0 1 1 4.656 -1.377" />
                <path d="M16 4v3.803a6.019 6.019 0 0 1 2.658 3.197h1.341a1 1 0 0 1 1 1v2a1 1 0 0 1 -1 1h-1.342c-.336 .95 -.907 1.8 -1.658 2.473v2.027a1.5 1.5 0 0 1 -3 0v-.583a6.04 6.04 0 0 1 -1 .083h-4a6.04 6.04 0 0 1 -1 -.083v.583a1.5 1.5 0 0 1 -3 0v-2l0 -.027a6 6 0 0 1 4 -10.473h2.5l4.5 -3h0z" />
            </svg>
    </div>
</main>

<footer></footer>
</body>
</html>
