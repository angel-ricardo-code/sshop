<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Estadísticas...</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/stats.css')}}">
    <script src="{{asset('js/diagrams.js')}}" defer></script>
</head>
<body>
<x-header></x-header>

<main>

    <h1 class="mainHeading">Estadísticas</h1>

    <section class="distribucion">
        <h2>Distibución por categorías:</h2>

        <canvas id="categoría_distribution" width="300" height="300">

        </canvas>
        <div id="diagram_leyend" class="diagram_leyend">
        </div>
    </section>

    <section id="ganancias">
        <div class="container">
            <div class="vendidos">
                <h2>Más vendidos</h2>

                <div class="resultados">
                    <div class="titles">
                        <span>Producto</span>
                        <span>No. (u) vendidas</span>
                    </div>

                    <ul class="prodList">

                        @foreach($bestSellers as $item)

                            <x-prod_stat>
                                <x-slot:nombre>{{$item->nombre}}</x-slot:nombre>
                                <x-slot:num>{{$item->sum}}</x-slot:num>
                            </x-prod_stat>

                        @endforeach


                    </ul>


                </div>
                <hr>
                <div class="ver_mas">
                    <a class="ver_mas" href="/estadisticas/producto-ventas">Ver todos</a>
                </div>

            </div>

            <div class="ganancias">
                <h2>Aportan más</h2>
                <div class="resultados">
                    <div class="titles">
                        <span>Producto</span>
                        <span>Ganancia reportada (cup)</span>
                    </div>

                    <ul class="prodList">

                        @foreach($bestProfit as $item)

                            <x-prod_stat>
                                <x-slot:nombre>{{$item->nombre}}</x-slot:nombre>
                                <x-slot:num>{{$item->ganancia}}</x-slot:num>
                            </x-prod_stat>

                        @endforeach

                    </ul>
                </div>
                <hr>
                <div class="ver_mas">
                    <a class="ver_mas" href="/estadisticas/producto-ganancias">Ver todos</a>
                </div>
            </div>


        </div>
    </section>

    <section class="stock">
        <div class="container">

            <div class="agotados">
                <h2>Productos agotados</h2>
                <div class="titles"><span class="prod">Producto</span></div>
                <ul class="prodList">

                    @foreach($outStock as $item)

                        <x-prod_stat>
                            <x-slot:nombre>{{$item->nombre}}</x-slot:nombre>
                            <x-slot:num>{{null}}</x-slot:num>
                        </x-prod_stat>

                    @endforeach

                </ul>
            </div>

            <div class="lowStock">
                <h2 title="Muestra el stock del producto restante en base a sus ventas semanales.">Casi agotados</h2>
                <div class="titles"><span class="prod">Producto</span>
                    <span class="prod">stock</span></div>
                <ul class="prodList">

                    @foreach($almostStock as $item)

                        <x-prod_stat>
                            <x-slot:nombre>{{$item->nombre}}</x-slot:nombre>
                            <x-slot:num>{{$item->stock}}</x-slot:num>
                        </x-prod_stat>

                    @endforeach

                </ul>

                <hr>
                <div class="ver_mas">
                    <a class="ver_mas" href="/estadisticas/producto-lowStock">Ver todos</a>
                </div>
            </div>

        </div>
    </section>

    <section class="categorias">
    </section>

</main>

<footer></footer>
</body>
</html>
