<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editando...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="{{asset('css/compras.css')}}">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">

</head>
<body>

<x-header></x-header>
<main>
    <h1 class="mainHeading">Editando productos:</h1>



    <div class="container">
        <form class="product_form" id="product_form" action="/agregar-productos" method="post">
            @csrf


            @for($i =0 ; $i <  sizeof($productos); $i++)

                <x-new_producto>
                    <x-slot:i>{{$i}}</x-slot:i>
                    <x-slot:productos>{{dd($productos[$i])}}</x-slot:productos>
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
