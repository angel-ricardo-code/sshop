<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventario</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">
    <script src="{{asset('js/autocompletar.js')}}" defer></script>
</head>
<body>
<x-header></x-header>

<main>

    <h1 class="mainHeading">Nueva Venta</h1>

    <section id="productosContainer">

        <form id="producto_form" action="" method="post">

            @csrf

            <div class="columns">
                <div class="left">


                        <label for="producto_select">Producto</label>
                        <select name="producto" id="producto_select">

                            @foreach( (new \App\Models\Inventario())->display($user)  as $producto)


                                @if($producto->stock > 0)
                                    <x-opt>
                                        <x-slot:id>{{$producto->id}}</x-slot:id>
                                        <x-slot:nombre>{{$producto->nombre}}</x-slot:nombre>
                                    </x-opt>

                                @endif
                            @endforeach

                        </select>


                </div>
                <div class="rigth">
                    <label for="cantidad_input">Cantidad</label>
                    <input type="number" name="cantidad" id="cantidad_input">
                </div>
                <div class="destroyButton">
                    &minus;
                </div>
            </div>

            <div class="field opacity_half">
                <label for="pv">Precio venta</label>
                <input type="number" name="precio_venta" id="pv">
            </div>

            @if($errors->any())
                <div class="errors">
                @foreach($errors->all() as $error)
                   <span>{{$error}}</span>
                @endforeach
                </div>
            @endif


        </form>

    </section>


    <div class="buttonsContainer">
        <button class="cancelButton"><a href="/inicio">Cancelar</a></button>
        <button class="submitButton" type="submit" form="producto_form" formaction="{{route('venta.store')}}">Siguiente</button>
    </div>


</main>

<footer></footer>
</body>
</html>

