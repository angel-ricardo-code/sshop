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


    <section id="productosContainer">


        <form id="confirmation_form" action="" method="post">

            @if($ids)
                @foreach( $ids as $id)
                    <input type="hidden" name="selected[]" value="{{$id}}">
                @endforeach
            @endif

            <h2>Confirmar eliminación</h2>

            @csrf



            <div class="resumen">
                Las estadísticas para productos eliminados no están disponibles, igualmente, el cálculo de
                varias métricas se puede ver afectado por esta eliminación, estás seguro/(a) que quieres eliminar los productos seleccionados.
                <br>
            </div>


            <hr>
            <div class="buttons">
                <button class="cancelButton" name="response" value="cancel" >Cancelar</button>
                <button type="submit" class="submitButton" name="response" value="delete">Eliminar</button>
            </div>
        </form>



    </section>






</main>

<footer></footer>
</body>
</html>

