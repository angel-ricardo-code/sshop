<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Agregando productos</title>
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/compras.css')}}">

</head>
<body>

<x-header></x-header>
<main>
    <h1 class="mainHeading">Agregando productos:</h1>

    <div class="container">
        <form class="product_form" id="product_form" action="/agregar-productos" method="post">
            @csrf


            @for($i =0 ; $i < 1; $i++)

                <x-new_producto>
                    <x-slot:i>{{$i}}</x-slot:i>
                </x-new_producto>

            @endfor


            <button  type="reset" class="reset">
                <img class="ico refresh" src="{{asset('icos/refresh.svg')}}">
            </button>
        </form>


    </div>
    <div class="buttonsContainer">
        <button class="cancelButton" type="submit" name="action" form="product_form" value="cancel">Cancelar</button>
        <button class="submitButton" type="submit" form="product_form" name="action" value="add">Agregar</button>
    </div>

</main>
<footer></footer>


</body>
</html>
