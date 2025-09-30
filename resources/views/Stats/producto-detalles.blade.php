<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$header}}</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/stats.css')}}">
</head>
<body>
<main style="height: 100dvh">

    <h1 class="mainHeading">Información de ventas.</h1>


    <section id="ganancias">
        <div class="container">

                <h2>{{$header}}</h2>

                <div class="resultados">

                    @if($stats == "producto-ventas")

                        <div class="titles">
                            <span>Producto</span>
                            <span>No. (u) vendidas</span>
                        </div>
                    @endif

                    @if($stats == "producto-ganancias")
                        <div class="titles">
                            <span>Producto</span>
                            <span>Ganancia reportada (cup)</span>
                        </div>
                    @endif

                    @if($stats == "producto-lowStock")


                        <div class="titles">
                            <span class="prod">Producto</span>
                            <span class="prod">stock</span>
                        </div>

                    @endif


                    <ul class="prodList">
                        @foreach($result as $item)

                            <x-prod_stat>
                                <x-slot:nombre>{{$item->nombre}}</x-slot:nombre>
                                <x-slot:num>{{$item->num}}</x-slot:num>
                            </x-prod_stat>
                        @endforeach
                    </ul>

                </div>
       </div>
    </section>

    <div class="buttonsContainer">
        <form action="/goBack" method="post">
            @csrf
            <button type="submit" class="cancelButton">Atrás</button>
        </form>
    </div>


</main>

<footer></footer>
</body>
</html>
