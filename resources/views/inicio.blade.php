
<!doctype html>
<html lang="es"
>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/home.css')}}">
    <link rel="stylesheet" href="{{asset('css/header.css')}}">
    <title>Inicio</title>
</head>
<body>
<x-header></x-header>

<main>

    <h1 class="mainHeading">{{$greeting}}</h1>
    <h2 class="date_heading"><span class="today">Hoy</span> <br>
        <span class="date">
            {{now()->toDateString()}}
        </span>
    </h2><br>

    <section class="resumen">


        <div class="container">

            <div class="split">

                <div class="ventas">
                    <h1 class="title">Ventas</h1>
                    <div class="no_ventas">{{$count}}</div>
                </div>

                <hr>

                <div class="totales">
                    <div class="field">
                        <label for="" class="nombre_campo">Total de venta</label>
                        <span class="number">{{$total_vendido}}</span>
                    </div>
                    <div class="field">
                        <label for="" class="nombre_campo">Ganancia del día</label>
                        <span class="number">{{$ganancia}}</span>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <br>
    <section class="container">
        <h1 class="title al-l">Ultimas ventas <svg
                xmlns="http://www.w3.org/2000/svg"
                width="24"
                height="24"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-clock-bolt"
            >
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M20.984 12.53a9 9 0 1 0 -7.552 8.355" />
                <path d="M12 7v5l3 3" />
                <path d="M19 16l-2 3h4l-2 3" />
            </svg></h1>
        <div class="operaciones">

            <ul>

                @foreach ($operaciones as $operacion)

                    <li class="operation">
                        <input type="hidden" form="quick" name="product_id" value="{{$operacion->id_producto}}">
                     <div style="display: inherit; gap: 0.5em; align-items: center">
                         <span class="date_tag hour">{{ \App\Http\Controllers\str_from_to( $operacion->created_at,11,15)}}</span>
                         <span class="date_tag venta_date">{{ \App\Http\Controllers\str_from_to( $operacion->created_at,5,10)}}</span>
                         <div class="prod_name">{{$operacion->nombre}}</div>
                     </div>

                        <button style="box-shadow: none" type="submit" class="quick_button" form="quick">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                opacity="0.6"
                                height="24"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="rgba(110, 76, 62, 1)"
                                stroke-width="3"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-right no-shadow"
                            >
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M5 12l14 0" />
                                <path d="M15 16l4 -4" />
                                <path d="M15 8l4 4" />
                            </svg>
                        </button>
                    </li>

                @endforeach
            </ul>

            <form method="post" id="quick" action="/quick">
            @csrf
            </form>
        </div>
    </section>




</main>

<footer></footer>
</body>
</html>
