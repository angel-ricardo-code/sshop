<!DOCTYPE html>
@php $i = 0;
@endphp
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editando...</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, height=device-height">
    <link rel="stylesheet" href="{{asset('css/compras.css')}}">
    <link rel="stylesheet" href="{{asset('css/global.css')}}">
    <link rel="stylesheet" href="{{asset('css/edit-producto.css')}}">

</head>
<body>

<x-header></x-header>
<main style="font-size: 0.9em">
    <h1 class="mainHeading">Editando productos:</h1>



    <div class="container" style="font-size: 0.8em">
        <form class="product_form" id="product_form" action="/editar-productos" method="post">
            @csrf


            @foreach( session('productos') as $producto)


                <x-producto>
                    <x-slot:i>{{$i}}</x-slot:i>
                    <x-slot:id>{{$producto->id_producto}}</x-slot:id>
                    <x-slot:nombre>{{$producto->nombre}}</x-slot:nombre>
                    <x-slot:stock>{{$producto->stock}}</x-slot:stock>
                    <x-slot:precio_venta>{{$producto->precio_venta}}</x-slot:precio_venta>
                    <x-slot:precio_compra>{{$producto->precio_compra}}</x-slot:precio_compra>
                    <x-slot:categoria>{{$producto->categoria}}</x-slot:categoria>
                </x-producto>

                <hr>

                @php $i++ @endphp

            @endforeach


            @if($errors->any())
                <div class="errors">
                    @foreach( $errors->all() as $error)
                        <span class="error">{{$error}}</span>
                    @endforeach
                </div>
            @endif

            <button form="product_form" type="reset" class="reset">
                <img class="ico refresh" src="{{asset('icos/refresh.svg')}}">
            </button>
        </form>


    </div>



    <div class="buttonsContainer">
        <button class="cancelButton" type="submit" name="action" form="product_form" formaction="/editar-productos" formmethod="POST" value="cancel">Cancelar</button>
        <button class="submitButton" type="submit" form="product_form" name="action" formaction="/editar-productos" formmethod="POST" value="update">Actualizar</button>
    </div>

</main>
<footer></footer>


</body>
</html>
