<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventario</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/inventario.css')}}">
</head>
<body>
<x-header></x-header>

<main>

    <h1 class="mainHeading">Inventario</h1>

    @if($messages)
        <div class="messages">

            <div class="messge">{{$messages}}</div>
        </div>
    @endif


    <section>
        <div class="tableContainer">


            <li class="heading">
                <span class="titles">Nombre</span>
                <span class="titles">Cantidad</span>
                <span>Categoría</span>
                <span>Precio venta</span>
            </li>

            <ul class="table">


                @foreach( $productos as $producto)

                    <li class="producto">
                        {{--                        <div style="display: flex; gap: 0.3em; position: sticky; left: 0; backdrop-filter: blur(5px)">--}}
                        <input class="checkboxCOlumn" form="selection_form" type="checkbox" name="selected[]"
                               value="{{$producto->id_producto}}">
                        <span class="p_name" title="Nombre">{{$producto->nombre_producto}}</span>
                        {{--                        </div>--}}

                        <span class="p_stock" title="Cantidad">{{$producto->stock}}</span>
                        <span title="Categoría"> {{$producto->categoria}}</span>
                        <span title="Precio de venta"> {{$producto->precio_venta}}<span class="pesos"> cup</span></span>
                    </li>

                @endforeach


                <hr>
                <div class="addProduct"><a href="/agregar-productos">&plus;</a></div>


            </ul>


        </div>

    </section>


    <form id="selection_form" action="/inventario" method="post">
        @csrf
    </form>

    <div class="buttonsContainer">
        <button class="cancelButton" type="submit" name="action" value="delete" form="selection_form">Eliminar</button>
        <button class="submitButton" type="submit" name="action" value="edit" form="selection_form">Editar</button>
    </div>


</main>

<footer></footer>
</body>
</html>
